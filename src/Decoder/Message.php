<?php

declare(strict_types=1);

namespace Genkgo\Camt\Decoder;

use SimpleXMLElement;
use Genkgo\Camt\DTO;
use Genkgo\Camt\Decoder\Factory\DTO as DTOFactory;

abstract class Message
{
    /**
     * @var Record
     */
    protected $recordDecoder;
    /**
     * @var DateDecoderInterface
     */
    protected $dateDecoder;

    /**
     * Message constructor.
     * @param Record $recordDecoder
     * @param DateDecoderInterface $dateDecoder
     */
    public function __construct(Record $recordDecoder, DateDecoderInterface $dateDecoder)
    {
        $this->recordDecoder = $recordDecoder;
        $this->dateDecoder = $dateDecoder;
    }

    /**
     * @param DTO\Message      $message
     * @param SimpleXMLElement $document
     */
    public function addGroupHeader(DTO\Message $message, SimpleXMLElement $document): void
    {
        $xmlGroupHeader = $this->getRootElement($document)->GrpHdr;
        $groupHeader = new DTO\GroupHeader(
            (string)$xmlGroupHeader->MsgId,
            $this->dateDecoder->decode((string)$xmlGroupHeader->CreDtTm)
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

    /**
     * @param DTO\Record       $record
     * @param SimpleXMLElement $xmlRecord
     */
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

    /**
     * @param DTO\Message      $message
     * @param SimpleXMLElement $document
     */
    abstract public function addRecords(DTO\Message $message, SimpleXMLElement $document): void;

    /**
     * @param SimpleXMLElement $document
     *
     * @return SimpleXMLElement
     */
    abstract public function getRootElement(SimpleXMLElement $document): SimpleXMLElement;
}
