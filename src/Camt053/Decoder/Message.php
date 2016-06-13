<?php

namespace Genkgo\Camt\Camt053\Decoder;

use Genkgo\Camt\Decoder\Message as BaseMessageDecoder;
use Genkgo\Camt\Camt053\DTO as Camt053DTO;
use Genkgo\Camt\DTO;
use \SimpleXMLElement;
use \DateTimeImmutable;
use Genkgo\Camt\Iban;

class Message extends BaseMessageDecoder
{
    /**
     * @param DTO\Message      $message
     * @param SimpleXMLElement $document
     */
    public function addGroupHeader(DTO\Message $message, SimpleXMLElement $document)
    {
        $xmlGroupHeader = $document->BkToCstmrStmt->GrpHdr;
        $groupHeader = new DTO\GroupHeader(
            (string)$xmlGroupHeader->MsgId,
            new DateTimeImmutable((string)$xmlGroupHeader->CreDtTm)
        );

        $message->setGroupHeader($groupHeader);
    }

    /**
     * @param DTO\Message      $message
     * @param SimpleXMLElement $document
     */
    public function addRecords(DTO\Message $message, SimpleXMLElement $document)
    {
        $statements = [];

        $xmlStatements = $document->BkToCstmrStmt->Stmt;
        foreach ($xmlStatements as $xmlStatement) {
            $statement = new Camt053DTO\Statement(
                (string) $xmlStatement->Id,
                new DateTimeImmutable((string)$xmlStatement->CreDtTm),
                $this->getAccount($xmlStatement)
            );

            $this->recordDecoder->addBalances($statement, $xmlStatement);
            $this->recordDecoder->addEntries($statement, $xmlStatement);

            $statements[] = $statement;
        }

        $message->setRecords($statements);
    }

    /**
     * @param SimpleXMLElement $xmlRecord
     *
     * @return DTO\Account
     */
    protected function getAccount(SimpleXMLElement $xmlRecord)
    {
        if (isset($xmlRecord->Acct->Id->IBAN)) {
            return new DTO\IbanAccount(new Iban((string) $xmlRecord->Acct->Id->IBAN));
        }

        $xmlOtherIdentification = $xmlRecord->Acct->Id->Othr;
        $otherAccount = new Camt053DTO\OtherAccount((string) $xmlOtherIdentification->Id);

        if (isset($xmlOtherIdentification->SchmeNm)) {
            if (isset($xmlOtherIdentification->SchmeNm->Cd)) {
                $otherAccount->setSchemeName((string) $xmlOtherIdentification->SchmeNm->Cd);
            }

            if (isset($otherIdentification->SchmeNm->Prtry)) {
                $otherAccount->setSchemeName((string) $xmlOtherIdentification->SchmeNm->Prtry);
            }
        }

        if (isset($xmlOtherIdentification->Issr)) {
            $otherAccount->setIssuer($xmlOtherIdentification->Issr);
        }

        return $otherAccount;
    }
}
