<?php

declare(strict_types=1);

namespace Genkgo\Camt\Camt053\Decoder;

use Genkgo\Camt\Camt053\DTO as Camt053DTO;
use Genkgo\Camt\Decoder\Message as BaseMessageDecoder;
use Genkgo\Camt\DTO;
use SimpleXMLElement;
use Genkgo\Camt\Iban;

class Message extends BaseMessageDecoder
{
    public function addRecords(DTO\Message $message, SimpleXMLElement $document): void
    {
        $statements = [];

        $xmlStatements = $this->getRootElement($document)->Stmt;
        foreach ($xmlStatements as $xmlStatement) {
            $statement = new Camt053DTO\Statement(
                (string)$xmlStatement->Id,
                $this->dateDecoder->decode((string)$xmlStatement->CreDtTm),
                $this->getAccount($xmlStatement)
            );

            if (isset($xmlStatement->StmtPgntn)) {
                $statement->setPagination(
                    new DTO\Pagination(
                        (string)$xmlStatement->StmtPgntn->PgNb,
                        ('true' === (string)$xmlStatement->StmtPgntn->LastPgInd) ? true : false
                    )
                );
            }

            if (isset($xmlStatement->AddtlStmtInf)) {
                $statement->setAdditionalInformation((string)$xmlStatement->AddtlStmtInf);
            }

            $this->addCommonRecordInformation($statement, $xmlStatement);
            $this->recordDecoder->addBalances($statement, $xmlStatement);
            $this->recordDecoder->addEntries($statement, $xmlStatement);

            $statements[] = $statement;
        }

        $message->setRecords($statements);
    }

    /**
     * {@inheritdoc}
     */
    public function getRootElement(SimpleXMLElement $document): SimpleXMLElement
    {
        return $document->BkToCstmrStmt;
    }

    protected function getAccount(SimpleXMLElement $xmlRecord): DTO\Account
    {
        if (isset($xmlRecord->Acct->Id->IBAN)) {
            $account = new DTO\IbanAccount(new Iban((string)$xmlRecord->Acct->Id->IBAN));
        } else {
            $xmlOtherIdentification = $xmlRecord->Acct->Id->Othr;
            $account = new DTO\OtherAccount((string)$xmlOtherIdentification->Id);

            if (isset($xmlOtherIdentification->SchmeNm)) {
                if (isset($xmlOtherIdentification->SchmeNm->Cd)) {
                    $account->setSchemeName((string)$xmlOtherIdentification->SchmeNm->Cd);
                }

                if (isset($xmlOtherIdentification->SchmeNm->Prtry)) {
                    $account->setSchemeName((string)$xmlOtherIdentification->SchmeNm->Prtry);
                }
            }

            if (isset($xmlOtherIdentification->Issr)) {
                $account->setIssuer((string)$xmlOtherIdentification->Issr);
            }
        }

        if ($Ownr = data_get($xmlRecord, 'Acct.Ownr')) {
            $this->accountAddOwnerInfo($account, $Ownr);
        }
        if ($Svcr = data_get($xmlRecord, 'Acct.Svcr')) {
            $this->accountAddServicerInfo($account, $Svcr);
        }
        if ($Ccy = data_get($xmlRecord, 'Acct.Ccy')) {
            $account->setCurrency(new \Money\Currency((string)$Ccy));
        }

        return $account;
    }
}
