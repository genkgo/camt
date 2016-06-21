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

        return $recipient;
    }
}
