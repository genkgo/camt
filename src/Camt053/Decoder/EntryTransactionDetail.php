<?php

declare(strict_types=1);

namespace Genkgo\Camt\Camt053\Decoder;

use Genkgo\Camt\Decoder\EntryTransactionDetail as BaseDecoder;
use Genkgo\Camt\DTO;
use Genkgo\Camt\Iban;
use SimpleXMLElement;

class EntryTransactionDetail extends BaseDecoder
{
    /**
     * @inheritDoc
     */
    public function getRelatedPartyAccount(?SimpleXMLElement $xmlRelatedPartyTypeAccount): ?DTO\Account
    {
        if (!$xmlRelatedPartyTypeAccount) {
            return null;
        }

        if (false === isset($xmlRelatedPartyTypeAccount->Id)) {
            return null;
        }

        if (isset($xmlRelatedPartyTypeAccount->Id->IBAN) && $ibanCode = (string) $xmlRelatedPartyTypeAccount->Id->IBAN) {
            return new DTO\IbanAccount(new Iban($ibanCode));
        }

        if (false === isset($xmlRelatedPartyTypeAccount->Id->Othr)) {
            return null;
        }

        $xmlOtherIdentification = $xmlRelatedPartyTypeAccount->Id->Othr;
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
            $otherAccount->setIssuer((string) $xmlOtherIdentification->Issr);
        }

        return $otherAccount;
    }
    
    public function addCharges(DTO\EntryTransactionDetail $detail, SimpleXMLElement $xmlDetail): void
    {
        if (isset($xmlDetail->Chrgs)) {
            $charges = new DTO\Charges();

            if (isset($xmlDetail->Chrgs->TtlChrgsAndTaxAmt) && (string) $xmlDetail->Chrgs->TtlChrgsAndTaxAmt) {
                $money = $this->moneyFactory->create($xmlDetail->Chrgs->TtlChrgsAndTaxAmt, null);
                $charges->setTotalChargesAndTaxAmount($money);
            }

            $chargesRecords = $xmlDetail->Chrgs;
            if ($chargesRecords !== null) {

                /** @var SimpleXMLElement $chargesRecord */
                foreach ($xmlDetail->Chrgs as $chargesRecord) {
                    $chargesDetail = new DTO\ChargesRecord();

                    if (isset($chargesRecord->Amt) && (string) $chargesRecord->Amt) {
                        $money = $this->moneyFactory->create($chargesRecord->Amt, $chargesRecord->CdtDbtInd);
                        $chargesDetail->setAmount($money);
                    }
                    if (isset($chargesRecord->CdtDbtInd) && (string) $chargesRecord->CdtDbtInd === 'true') {
                        $chargesDetail->setChargesIncludedIndicator(true);
                    }
                    if (isset($chargesRecord->Tp->Prtry->Id) && (string) $chargesRecord->Tp->Prtry->Id) {
                        $chargesDetail->setIdentification((string) $chargesRecord->Tp->Prtry->Id);
                    }
                    $charges->addRecord($chargesDetail);
                }
            }
            $detail->setCharges($charges);
        }
    }
}
