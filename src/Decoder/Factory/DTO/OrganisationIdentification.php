<?php

declare(strict_types=1);

namespace Genkgo\Camt\Decoder\Factory\DTO;

use Genkgo\Camt\DTO;
use SimpleXMLElement;

class OrganisationIdentification
{
    use Behavior\Mapping;

    public static function createFromXml(SimpleXMLElement $xmlOrganisationIdentification): DTO\OrganisationIdentification
    {
        $mapping = [
            ['setter' => 'setBic', 'value' => 'BIC'],
            ['setter' => 'setBic', 'value' => 'BICOrBEI'],
            ['setter' => 'setBic', 'value' => 'AnyBIC'],
            ['setter' => 'setBei', 'value' => 'BICOrBEI'],
            ['setter' => 'setIbei', 'value' => 'IBEI'],
            ['setter' => 'setBei', 'value' => 'BEI'],
            ['setter' => 'setEangln', 'value' => 'EANGLN'],
            ['setter' => 'setChipsUniversalId', 'value' => 'USCHU'],
            ['setter' => 'setDuns', 'value' => 'DUNS'],
            ['setter' => 'setBankPartyId', 'value' => 'BkPtyId'],
            ['setter' => 'setTaxId', 'value' => 'TaxIdNb'],
        ];

        $organisationIdentification = new DTO\OrganisationIdentification();

        static::map($organisationIdentification, $xmlOrganisationIdentification, $mapping);

        if (isset($xmlOrganisationIdentification->PrtryId)) {
            $other = $xmlOrganisationIdentification->PrtryId;
        }
        if (isset($xmlOrganisationIdentification->Othr)) {
            $other = $xmlOrganisationIdentification->Othr;
        }

        if (isset($other)) {
            if (isset($other->Id)) {
                $organisationIdentification->setOtherId(
                    (string) $other->Id
                );
            }
            if (isset($other->Issr)) {
                $organisationIdentification->setOtherIssuer(
                    (string) $other->Issr
                );
            }
            if (isset($other->Tp)) {
                $organisationIdentification->setOtherType(
                    (string) $other->Tp
                );
            }
            if (isset($other->SchmeNm)) {
                $organisationIdentification->setOtherSchemeName(
                    (string) $other->SchmeNm
                );
            }
        }

        return $organisationIdentification;
    }
}
