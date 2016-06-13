<?php

namespace Genkgo\Camt\Camt053\Decoder;

use Genkgo\Camt\DTO;
use Genkgo\Camt\Camt053\DTO as Camt053DTO;
use Genkgo\Camt\Decoder\EntryTransactionDetail as BaseDecoder;
use \SimpleXMLElement;
use Genkgo\Camt\Iban;

class EntryTransactionDetail extends BaseDecoder
{
    /**
     * {@inheritdoc}
     */
    public function getRelatedPartyAccount(SimpleXMLElement $xmlRelatedPartyTypeAccount)
    {
        if (false === isset($xmlRelatedPartyTypeAccount->Id)) {
            return;
        }

        if (isset($xmlRelatedPartyTypeAccount->Id->IBAN) && $ibanCode = (string) $xmlRelatedPartyTypeAccount->Id->IBAN) {
            return new DTO\IbanAccount(new Iban($ibanCode));
        }

        if (false === isset($xmlRelatedPartyTypeAccount->Id->Othr)) {
            return;
        }

        $xmlOtherIdentification = $xmlRelatedPartyTypeAccount->Id->Othr;
        $otherAccount = new Camt053DTO\OtherAccount((string) $xmlOtherIdentification->Id);

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
}
