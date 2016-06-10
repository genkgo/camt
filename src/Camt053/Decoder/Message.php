<?php

namespace Genkgo\Camt\Camt053\Decoder;

use Genkgo\Camt\Camt053\DTO;
use DateTimeImmutable;
use SimpleXMLElement;
use Genkgo\Camt\Iban;

class Message
{
    /**
     * @var Statement
     */
    private $statementDecoder;

    public function __construct(Statement $statementDecoder)
    {
        $this->statementDecoder = $statementDecoder;
    }

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
    public function addStatements(DTO\Message $message, SimpleXMLElement $document)
    {
        $statements = [];

        $xmlStatements = $document->BkToCstmrStmt->Stmt;
        foreach ($xmlStatements as $xmlStatement) {
            $statement = new DTO\Statement(
                (string) $xmlStatement->Id,
                new DateTimeImmutable((string)$xmlStatement->CreDtTm),
                $this->getAccount($xmlStatement)
            );

            $this->statementDecoder->addBalances($statement, $xmlStatement);
            $this->statementDecoder->addEntries($statement, $xmlStatement);

            $statements[] = $statement;
        }

        $message->setStatements($statements);
    }

    /**
     * @param SimpleXMLElement $xmlStatement
     *
     * @return DTO\Account
     */
    private function getAccount(SimpleXMLElement $xmlStatement)
    {
        if (isset($xmlStatement->Acct->Id->IBAN)) {
            return new DTO\IbanAccount(new Iban((string) $xmlStatement->Acct->Id->IBAN));
        }

        $xmlOtherIdentification = $xmlStatement->Acct->Id->Othr;
        $otherAccount = new DTO\OtherAccount((string) $xmlOtherIdentification->Id);

        if (isset($otherIdentification->SchmeNm)) {
            if (isset($otherIdentification->SchmeNm->Cd)) {
                $otherAccount->setSchemeName((string) $xmlOtherIdentification->SchmeNm->Cd);
            }

            if (isset($otherIdentification->SchmeNm->Prtry)) {
                $otherAccount->setSchemeName((string) $xmlOtherIdentification->SchmeNm->Prtry);
            }
        }

        if (isset($otherIdentification->Issr)) {
            $otherAccount->setIssuer((string) $xmlOtherIdentification->Issr);
        }

        return $otherAccount;
    }
}
