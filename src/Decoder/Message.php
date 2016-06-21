<?php

namespace Genkgo\Camt\Decoder;

use DateTimeImmutable;
use SimpleXMLElement;
use Genkgo\Camt\DTO;
use Genkgo\Camt\Iban;

abstract class Message
{
    /**
     * @var Record
     */
    protected $recordDecoder;

    public function __construct(Record $recordDecoder)
    {
        $this->recordDecoder = $recordDecoder;
    }

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
     * @param DTO\Record       $record
     * @param SimpleXMLElement $xmlRecord
     */
    public function addCommonRecordInformation(DTO\Record $record, SimpleXMLElement $xmlRecord)
    {
        if (isset($xmlRecord->ElctrncSeqNb)) {
            $record->setElectronicSequenceNumber((string) $xmlRecord->ElctrncSeqNb);
        }
        if (isset($xmlRecord->CpyDplctInd)) {
            $record->setCopyDuplicateIndicator((string) $xmlRecord->CpyDplctInd);
        }
        if (isset($xmlRecord->LglSeqNb)) {
            $record->setLegalSequenceNumber((string) $xmlRecord->LglSeqNb);
        }
        if (isset($xmlRecord->FrToDt)) {
            $record->setFromDate(new DateTimeImmutable((string) $xmlRecord->FrToDt->FrDtTm));
            $record->setToDate(new DateTimeImmutable((string) $xmlRecord->FrToDt->ToDtTm));
        }
    }

    /**
     * @param DTO\Message      $message
     * @param SimpleXMLElement $document
     */
    abstract public function addRecords(DTO\Message $message, SimpleXMLElement $document);

    /**
     * @param SimpleXMLElement $document
     *
     * @return SimpleXMLElement
     */
    abstract public function getRootElement(SimpleXMLElement $document);
}
