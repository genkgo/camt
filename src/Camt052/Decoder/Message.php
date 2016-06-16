<?php

namespace Genkgo\Camt\Camt052\Decoder;

use Genkgo\Camt\Decoder\Message as BaseMessageDecoder;
use Genkgo\Camt\Camt052\DTO as Camt052DTO;
use Genkgo\Camt\DTO;
use \SimpleXMLElement;
use \DateTimeImmutable;
use Genkgo\Camt\Iban;

abstract class Message extends BaseMessageDecoder
{
    /**
     * @param DTO\Message      $message
     * @param SimpleXMLElement $document
     */
    public function addGroupHeader(DTO\Message $message, SimpleXMLElement $document)
    {
        $xmlGroupHeader = $this->getRootElement($document)->GrpHdr;
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
        $reports = [];

        $xmlReports = $this->getRootElement($document)->Rpt;
        foreach ($xmlReports as $xmlReport) {
            $report = new Camt052DTO\Report(
                (string) $xmlReport->Id,
                new DateTimeImmutable((string)$xmlReport->CreDtTm),
                $this->getAccount($xmlReport)
            );

            $this->recordDecoder->addBalances($report, $xmlReport);
            $this->recordDecoder->addEntries($report, $xmlReport);

            $reports[] = $report;
        }

        $message->setRecords($reports);
    }

    /**
     * @param SimpleXMLElement $document
     *
     * @return SimpleXMLElement
     */
    abstract public function getRootElement(SimpleXMLElement $document);

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

        if (isset($xmlRecord->Acct->Id->BBAN)) {
            return new Camt052DTO\BBANAccount((string) $xmlRecord->Acct->Id->BBAN);
        }

        if (isset($xmlRecord->Acct->Id->UPIC)) {
            return new Camt052DTO\UPICAccount((string) $xmlRecord->Acct->Id->UPIC);
        }

        if (isset($xmlRecord->Acct->Id->PrtryAcct)) {
            return new Camt052DTO\ProprietaryAccount((string) $xmlRecord->Acct->Id->PrtryAcct->Id);
        }
    }
}
