<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

class Recipient implements RelatedPartyTypeInterface
{
    private ?Address $address = null;

    private ?string $countryOfResidence = null;

    private ?ContactDetails $contactDetails = null;

    private ?Identification $identification = null;

    public function __construct(private ?string $name = null)
    {
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(Address $address): void
    {
        $this->address = $address;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getCountryOfResidence(): ?string
    {
        return $this->countryOfResidence;
    }

    public function setCountryOfResidence(string $countryOfResidence): void
    {
        $this->countryOfResidence = $countryOfResidence;
    }

    public function getContactDetails(): ?ContactDetails
    {
        return $this->contactDetails;
    }

    public function setContactDetails(ContactDetails $contactDetails): void
    {
        $this->contactDetails = $contactDetails;
    }

    public function getIdentification(): ?Identification
    {
        return $this->identification;
    }

    public function setIdentification(Identification $identification): void
    {
        $this->identification = $identification;
    }
}
