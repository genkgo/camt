<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

class Recipient implements RelatedPartyTypeInterface
{
    /**
     * @var null|string
     */
    private $id;

    /**
     * @var null|Address
     */
    private $address;

    /**
     * @var null|string
     */
    private $name;

    /**
     * @var null|string
     */
    private $countryOfResidence;

    /**
     * @var null|ContactDetails
     */
    private $contactDetails;

    /**
     * @var null|Identification
     */
    private $identification;

    /**
     * @var null|string
     */
    private $typeName;

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

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getTypeName(): ?string
    {
        return $this->typeName;
    }

    public function setTypeName(?string $typeName): void
    {
        $this->typeName = $typeName;
    }
}
