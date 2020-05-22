<?php

declare(strict_types=1);

namespace Genkgo\Camt\Camt052\Decoder;

use Genkgo\Camt\Camt052\DTO as Camt052DTO;
use Genkgo\Camt\Decoder\Message as BaseMessageDecoder;
use Genkgo\Camt\DTO;
use Genkgo\Camt\Iban;
use SimpleXMLElement;

abstract class Message extends BaseMessageDecoder
{
    /**
     * @param DTO\Message $message
     * @param SimpleXMLElement $document
     */
    public function addRecords(DTO\Message $message, SimpleXMLElement $document): void
    {
        $reports = [];

        $xmlReports = $this->getRootElement($document)->Rpt;
        foreach ($xmlReports as $xmlReport) {
            $report = new Camt052DTO\Report(
                (string)$xmlReport->Id,
                $this->dateDecoder->decode((string)$xmlReport->CreDtTm),
                $this->getAccount($xmlReport)
            );

            if (isset($xmlReport->RptPgntn)) {
                $report->setPagination(
                    new DTO\Pagination(
                        (string)$xmlReport->RptPgntn->PgNb,
                        ('true' === (string)$xmlReport->RptPgntn->LastPgInd) ? true : false
                    )
                );
            }

            if (isset($xmlReport->AddtlRptInf)) {
                $report->setAdditionalInformation((string)$xmlReport->AddtlRptInf);
            }

            $this->addCommonRecordInformation($report, $xmlReport);
            $this->recordDecoder->addBalances($report, $xmlReport);
            $this->recordDecoder->addEntries($report, $xmlReport);

            $reports[] = $report;
        }

        $message->setRecords($reports);
    }

    /**
     * @param SimpleXMLElement $xmlRecord
     *
     * @return null|DTO\Account
     */
    protected function getAccount(SimpleXMLElement $xmlRecord)
    {
        $account = null;
        if (isset($xmlRecord->Acct->Id->IBAN)) {
            $account = new DTO\IbanAccount(new Iban((string)$xmlRecord->Acct->Id->IBAN));
        } elseif (isset($xmlRecord->Acct->Id->BBAN)) {
            $account = new DTO\BBANAccount((string)$xmlRecord->Acct->Id->BBAN);
        } elseif (isset($xmlRecord->Acct->Id->UPIC)) {
            $account = new DTO\UPICAccount((string)$xmlRecord->Acct->Id->UPIC);
        } elseif (isset($xmlRecord->Acct->Id->PrtryAcct)) {
            $account = new DTO\ProprietaryAccount((string)$xmlRecord->Acct->Id->PrtryAcct->Id);
        } elseif (isset($xmlRecord->Acct->Id->Othr)) {
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

        if ($account instanceof DTO\Account) {
            if ($xmlRecord->Acct->Ownr) {
                $this->accountAddOwnerInfo($account, $xmlRecord->Acct->Ownr);
            }
            if ($xmlRecord->Acct->Svcr) {
                $this->accountAddServicerInfo($account, $xmlRecord->Acct->Svcr);
            }
            if ($xmlRecord->Acct->Ccy) {
                $account->setCurrency(new \Money\Currency((string)$xmlRecord->Acct->Ccy));
            }
            return $account;
        }

        return null;
    }
}
