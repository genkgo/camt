<?php

namespace Genkgo\Camt\Camt054\Decoder;

use Genkgo\Camt\Decoder\Message as BaseMessageDecoder;
use Genkgo\Camt\Camt054\DTO as Camt054DTO;
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
    public function addRecords(DTO\Message $message, SimpleXMLElement $document)
    {
        $notifications = [];

        $xmlNotifications = $this->getRootElement($document)->Ntfctn;
        foreach ($xmlNotifications as $xmlNotification) {
            $notification = new Camt054DTO\Notification(
                (string) $xmlNotification->Id,
                new DateTimeImmutable((string)$xmlNotification->CreDtTm),
                $this->getAccount($xmlNotification)
            );

            if (isset($xmlNotification->NtfctnPgntn)) {
                $notification->setPagination(new DTO\Pagination(
                    (string) $xmlNotification->NtfctnPgntn->PgNb,
                    ('true' === (string) $xmlNotification->NtfctnPgntn->LastPgInd) ? true : false
                ));
            }

            if (isset($xmlNotification->AddtlNtfctnInf)) {
                $notification->setAdditionalInformation((string) $xmlNotification->AddtlNtfctnInf);
            }

            $this->addCommonRecordInformation($notification, $xmlNotification);
            $this->recordDecoder->addEntries($notification, $xmlNotification);

            $notifications[] = $notification;
        }

        $message->setRecords($notifications);
    }

    /**
     * {@inheritdoc}
     */
    public function getRootElement(SimpleXMLElement $document)
    {
        return $document->BkToCstmrDbtCdtNtfctn;
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

        if (isset($xmlRecord->Acct->Id->BBAN)) {
            return new DTO\BBANAccount((string) $xmlRecord->Acct->Id->BBAN);
        }

        if (isset($xmlRecord->Acct->Id->UPIC)) {
            return new DTO\UPICAccount((string) $xmlRecord->Acct->Id->UPIC);
        }

        if (isset($xmlRecord->Acct->Id->PrtryAcct)) {
            return new DTO\ProprietaryAccount((string) $xmlRecord->Acct->Id->PrtryAcct->Id);
        }

        if (isset($xmlRecord->Acct->Id->Othr)) {
            $xmlOtherIdentification = $xmlRecord->Acct->Id->Othr;
            $otherAccount = new DTO\OtherAccount((string) $xmlOtherIdentification->Id);

            if (isset($xmlOtherIdentification->SchmeNm)) {
                if (isset($xmlOtherIdentification->SchmeNm->Cd)) {
                    $otherAccount->setSchemeName((string) $xmlOtherIdentification->SchmeNm->Cd);
                }

                if (isset($xmlOtherIdentification->SchmeNm->Prtry)) {
                    $otherAccount->setSchemeName((string) $xmlOtherIdentification->SchmeNm->Prtry);
                }
            }

            if (isset($xmlOtherIdentification->Issr)) {
                $otherAccount->setIssuer($xmlOtherIdentification->Issr);
            }

            return $otherAccount;
        }
    }
}
