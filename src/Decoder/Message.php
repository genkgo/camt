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

    protected function accountAddOwnerInfo(DTO\Account $account, SimpleXMLElement $acctOwnrElement): void
    {
        $owner = new DTO\AccountOwner();
        if ($acctOwnrElement->Id->OrgId->Othr->Id) {
            $owner->setId((string)$acctOwnrElement->Id->OrgId->Othr->Id);
        }
        if ($acctOwnrElement->Id->PrvtId->Othr->Id) {
            $owner->setId((string)$acctOwnrElement->Id->PrvtId->Othr->Id);
        }
        if ($acctOwnrElement->Nm) {
            $owner->setName((string)$acctOwnrElement->Nm);
        }
        if ($acctOwnrElement->PstlAdr) {
            $address = \Genkgo\Camt\Decoder\Factory\DTO\Address::createFromXml($acctOwnrElement->PstlAdr);
            $owner->setAddress($address);
        }
        $account->setOwner($owner);
    }

    protected function accountAddServicerInfo(DTO\Account $account, SimpleXMLElement $acctSvcrElement): void
    {
        $servicer = new DTO\AccountServicer();
        if ($acctSvcrElement->FinInstnId->Othr->Id) {
            $servicer->setId((string)$acctSvcrElement->FinInstnId->Othr->Id);
        }
        if ($acctSvcrElement->FinInstnId->BIC) {
            $servicer->setBic((string)$acctSvcrElement->FinInstnId->BIC);
        }
        if ($acctSvcrElement->FinInstnId->Nm) {
            $servicer->setName((string)$acctSvcrElement->FinInstnId->Nm);
        }
        if ($acctSvcrElement->FinInstnId->Othr->SchmeNm->Cd) {
            $servicer->setSchmeNm((string)$acctSvcrElement->FinInstnId->Othr->SchmeNm->Cd);
        }

        if ($acctSvcrElement->FinInstnId->PstlAdr) {
            $address = \Genkgo\Camt\Decoder\Factory\DTO\Address::createFromXml($acctSvcrElement->FinInstnId->PstlAdr);
            $servicer->setAddress($address);
        }
        $account->setServicer($servicer);
    }
}
