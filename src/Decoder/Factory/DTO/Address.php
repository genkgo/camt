<?php

declare(strict_types=1);

namespace Genkgo\Camt\Decoder\Factory\DTO;

use Genkgo\Camt\DTO;
use SimpleXMLElement;

class Address
{
    public static function createFromXml(SimpleXMLElement $xmlAddress): DTO\Address
    {
        $address = new DTO\Address();

        if (isset($xmlAddress->Ctry)) {
            $address = $address->setCountry((string) $xmlAddress->Ctry);
        }
        if (isset($xmlAddress->CtrySubDvsn)) {
            $address = $address->setCountrySubDivision((string) $xmlAddress->CtrySubDvsn);
        }
        if (isset($xmlAddress->Dept)) {
            $address = $address->setDepartment((string) $xmlAddress->Dept);
        }
        if (isset($xmlAddress->SubDept)) {
            $address = $address->setSubDepartment((string) $xmlAddress->SubDept);
        }
        if (isset($xmlAddress->StrtNm)) {
            $address = $address->setStreetName((string) $xmlAddress->StrtNm);
        }
        if (isset($xmlAddress->BldgNb)) {
            $address = $address->setBuildingNumber((string) $xmlAddress->BldgNb);
        }
        if (isset($xmlAddress->PstCd)) {
            $address = $address->setPostCode((string) $xmlAddress->PstCd);
        }
        if (isset($xmlAddress->TwnNm)) {
            $address = $address->setTownName((string) $xmlAddress->TwnNm);
        }
        if (isset($xmlAddress->AdrLine)) {
            foreach ($xmlAddress->AdrLine as $line) {
                $address = $address->addAddressLine((string) $line);
            }
        }

        return $address;
    }
}
