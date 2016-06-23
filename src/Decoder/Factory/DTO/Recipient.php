<?php

namespace Genkgo\Camt\Decoder\Factory\DTO;

use SimpleXMLElement;
use Genkgo\Camt\DTO;

class Recipient
{
    /**
     * @param SimpleXMLElement $xmlRecipient
     *
     * @return DTO\Recipient
     */
    public static function createFromXml(SimpleXMLElement $xmlRecipient)
    {
        $recipient = new DTO\Recipient();

        if (isset($xmlRecipient->Nm)) {
            $recipient->setName((string) $xmlRecipient->Nm);
        }
        if (isset($xmlRecipient->PstlAdr)) {
            $recipient->setAddress(Address::createFromXml($xmlRecipient->PstlAdr));
        }
        if (isset($xmlRecipient->CtryOfRes)) {
            $recipient->setCountryOfResidence((string) $xmlRecipient->CtryOfRes);
        }
        if (isset($xmlRecipient->CtctDtls)) {
            $recipient->setContactDetails(ContactDetails::createFromXml($xmlRecipient->CtctDtls));
        }
        if (isset($xmlRecipient->Id)) {
            if (isset($xmlRecipient->Id->OrgId)) {
                $recipient->setIdentification(OrganisationIdentification::createFromXml($xmlRecipient->Id->OrgId));
            }
            if (isset($xmlRecipient->Id->PrvtId)) {
                $recipient->setIdentification(PersonIdentification::createFromXml($xmlRecipient->Id->PrvtId));
            }
        }

        return $recipient;
    }
}
