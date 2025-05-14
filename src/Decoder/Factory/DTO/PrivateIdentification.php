<?php

declare(strict_types=1);

namespace Genkgo\Camt\Decoder\Factory\DTO;

use Genkgo\Camt\Decoder\Date;
use Genkgo\Camt\DTO;
use SimpleXMLElement;

class PrivateIdentification
{
    public static function createFromXml(SimpleXMLElement $xmlPrivateIdentification): DTO\PrivateIdentification
    {
        $privateIdentification = new DTO\PrivateIdentification();
        if (isset($xmlPrivateIdentification->DtAndPlcOfBirth)) {
            if (isset($xmlPrivateIdentification->DtAndPlcOfBirth->BirthDt)) {
                $dateDecoder = new Date();
                $privateIdentification->setBirthDate($dateDecoder->decode((string) $xmlPrivateIdentification->DtAndPlcOfBirth->BirthDt));
            }
            if (isset($xmlPrivateIdentification->DtAndPlcOfBirth->PrvcOfBirth)) {
                $privateIdentification->setProvinceOfBirth((string) $xmlPrivateIdentification->DtAndPlcOfBirth->PrvcOfBirth);
            }
            if (isset($xmlPrivateIdentification->DtAndPlcOfBirth->CityOfBirth)) {
                $privateIdentification->setCityOfBirth((string) $xmlPrivateIdentification->DtAndPlcOfBirth->CityOfBirth);
            }
            if (isset($xmlPrivateIdentification->DtAndPlcOfBirth->CtryOfBirth)) {
                $privateIdentification->setCountryOfBirth((string) $xmlPrivateIdentification->DtAndPlcOfBirth->CtryOfBirth);
            }
        }
        if (isset($xmlPrivateIdentification->Othr)) {
            if (isset($xmlPrivateIdentification->Othr->Id)) {
                $privateIdentification->setOtherId((string) $xmlPrivateIdentification->Othr->Id);
            }

            if (isset($xmlPrivateIdentification->Othr->SchmeNm)) {
                if (isset($xmlPrivateIdentification->Othr->SchmeNm->Cd)) {
                    $privateIdentification->setOtherSchemeName((string) $xmlPrivateIdentification->Othr->SchmeNm->Cd);
                }
                if (isset($xmlPrivateIdentification->Othr->SchmeNm->Prtry)) {
                    $privateIdentification->setOtherSchemeName((string) $xmlPrivateIdentification->Othr->SchmeNm->Prtry);
                }
            }
            if (isset($xmlPrivateIdentification->Othr->Issr)) {
                $privateIdentification->setOtherIssuer((string) $xmlPrivateIdentification->Othr->Issr);
            }
        }

        return $privateIdentification;
    }
}
