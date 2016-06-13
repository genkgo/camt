<?php

namespace Genkgo\Camt\Camt052\Decoder;

use Genkgo\Camt\DTO;
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

        if (isset($xmlRelatedPartyTypeAccount->Id->IBAN)) {
            return new DTO\IbanAccount(new Iban((string) $xmlRelatedPartyTypeAccount->Id->IBAN));
        }

        if (isset($xmlRelatedPartyTypeAccount->Id->BBAN)) {
            return new Camt052DTO\BBANAccount((string) $xmlRelatedPartyTypeAccount->Id->BBAN);
        }

        if (isset($xmlRelatedPartyTypeAccount->Id->UPIC)) {
            return new Camt052DTO\UPICAccount((string) $xmlRelatedPartyTypeAccount->Id->UPIC);
        }

        if (isset($xmlRelatedPartyTypeAccount->Id->PrtryAcct)) {
            return new Camt052DTO\ProprietaryAccount((string) $xmlRelatedPartyTypeAccount->Id->PrtryAcct->Id);
        }
    }
}
