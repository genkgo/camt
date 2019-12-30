<?php

namespace Genkgo\Camt\Decoder\Factory\DTO;

use SimpleXMLElement;
use Genkgo\Camt\DTO;

class ContactDetails
{
    /**
     * @param SimpleXMLElement $xmlContactDetails
     *
     * @return DTO\ContactDetails
     */
    public static function createFromXml(SimpleXMLElement $xmlContactDetails): DTO\ContactDetails
    {
        $contactDetails = new DTO\ContactDetails();

        if (isset($xmlContactDetails->NmPrfx)) {
            $contactDetails->setNamePrefix((string) $xmlContactDetails->NmPrfx);
        }
        if (isset($xmlContactDetails->Nm)) {
            $contactDetails->setName((string) $xmlContactDetails->Nm);
        }
        if (isset($xmlContactDetails->PhneNb)) {
            $contactDetails->setPhoneNumber((string) $xmlContactDetails->PhneNb);
        }
        if (isset($xmlContactDetails->MobNb)) {
            $contactDetails->setMobileNumber((string) $xmlContactDetails->MobNb);
        }
        if (isset($xmlContactDetails->FaxNb)) {
            $contactDetails->setFaxNumber((string) $xmlContactDetails->FaxNb);
        }
        if (isset($xmlContactDetails->EmailAdr)) {
            $contactDetails->setEmailAddress((string) $xmlContactDetails->EmailAdr);
        }
        if (isset($xmlContactDetails->Othr)) {
            $contactDetails->setOther((string) $xmlContactDetails->Othr);
        }

        return $contactDetails;
    }
}
