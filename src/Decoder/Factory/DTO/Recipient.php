<?php

declare(strict_types=1);

namespace Genkgo\Camt\Decoder\Factory\DTO;

use Genkgo\Camt\DTO;
use SimpleXMLElement;

class Recipient
{
    public static function createFromXml(SimpleXMLElement $xmlRecipient): DTO\Recipient
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
        }

        return $recipient;
    }
}
