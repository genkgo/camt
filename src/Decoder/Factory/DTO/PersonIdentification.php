<?php

namespace Genkgo\Camt\Decoder\Factory\DTO;

use DateTimeImmutable;

class PersonIdentification
{
    use Behavior\Mapping;

    public static function createFromXml(SimpleXMLElement $xmlPersonIdentification)
    {
        $xmlPersonIdentification = new DTO\PersonIdentification();

        $mapping = [
            ['setter' => 'setDriversLicenseNumber', 'value' => 'DrvrsLicNb'],
            ['setter' => 'setCustomerNumber', 'value' => 'CstmrNb'],
            ['setter' => 'setSocialSecurityNumber', 'value' => 'SclSctyNb'],
            ['setter' => 'setAlienRegistrationNumber', 'value' => 'AlnRegnNb'],
            ['setter' => 'setPassportNumber', 'value' => 'PsptNb'],
            ['setter' => 'setTaxId', 'value' => 'TaxIdNb'],
            ['setter' => 'setIdCardNumber', 'value' => 'IdntyCardNb'],
            ['setter' => 'setEmployerId', 'value' => 'MplyrIdNb'],
        ];

        static::map($personIdentification, $xmlPersonIdentification, $mapping);

        if (isset($xmlPersonIdentification->DtAndPlcOfBirth)) {
            $xml = $xmlPersonIdentification->DtAndPlcOfBirth;

            if (isset($xml->BirthDt)) {
                $personIdentification->setBirthDate(new DateTimeImmutable((string) $xml->BirthDt));
            }
            if (isset($xml->PrvcOfBirth)) {
                $personIdentification->setProvinceOfBirth((string) $xml->PrvcOfBirth);
            }
            if (isset($xml->CityOfBirth)) {
                $personIdentification->setCityOfBirth((string) $xml->CityOfBirth);
            }
            if (isset($xml->CtryOfBirth)) {
                $personIdentification->setCountryOfBirth((string) $xml->CtryOfBirth);
            }
        }

        if (isset($xmlPersonIdentification->OthrId)) {
            if (isset($xmlPersonIdentification->OthrId->Id)) {
                $personIdentification->setOtherIdentification((string) $xmlPersonIdentification->OthrId->Id);
            }
            if (isset($xmlPersonIdentification->OthrId->IdTp)) {
                $personIdentification->setOtherIdentificationType((string) $xmlPersonIdentification->OthrId->IdTp);
            }
            if (isset($xmlPersonIdentification->OthrId->SchmeNm)) {
                $personIdentification->setOtherIdentificationSc((string) $xmlPersonIdentification->OthrId->IdTp);
            }
        }

        return $personIdentification;
    }
}
