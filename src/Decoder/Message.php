<?php

declare(strict_types=1);

namespace Genkgo\Camt\Decoder;

use Genkgo\Camt\Decoder\Factory\DTO as DTOFactory;
use Genkgo\Camt\DTO;
use SimpleXMLElement;

abstract class Message
{
    protected Record $recordDecoder;

    protected DateDecoderInterface $dateDecoder;

    /**
     * Message constructor.
     */
    public function __construct(Record $recordDecoder, DateDecoderInterface $dateDecoder)
    {
        $this->recordDecoder = $recordDecoder;
        $this->dateDecoder = $dateDecoder;
    }

    public function addGroupHeader(DTO\Message $message, SimpleXMLElement $document): void
    {
        $xmlGroupHeader = $this->getRootElement($document)->GrpHdr;
        $groupHeader = new DTO\GroupHeader(
            (string) $xmlGroupHeader->MsgId,
            $this->dateDecoder->decode((string) $xmlGroupHeader->CreDtTm)
        );

        if (isset($xmlGroupHeader->AddtlInf)) {
            $groupHeader->setAdditionalInformation((string) $xmlGroupHeader->AddtlInf);
        }

        if (isset($xmlGroupHeader->MsgRcpt)) {
            $groupHeader->setMessageRecipient(
                DTOFactory\Recipient::createFromXml($xmlGroupHeader->MsgRcpt)
            );
        }

        if (isset($xmlGroupHeader->MsgPgntn)) {
            $groupHeader->setPagination(new DTO\Pagination(
                (string) $xmlGroupHeader->MsgPgntn->PgNb,
                ('true' === (string) $xmlGroupHeader->MsgPgntn->LastPgInd) ? true : false
            ));
        }

        $message->setGroupHeader($groupHeader);
    }

    public function addCommonRecordInformation(DTO\Record $record, SimpleXMLElement $xmlRecord): void
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
            $record->setFromDate($this->dateDecoder->decode((string) $xmlRecord->FrToDt->FrDtTm));
            $record->setToDate($this->dateDecoder->decode((string) $xmlRecord->FrToDt->ToDtTm));
        }
    }

    abstract public function addRecords(DTO\Message $message, SimpleXMLElement $document): void;

    abstract public function getRootElement(SimpleXMLElement $document): SimpleXMLElement;
}
