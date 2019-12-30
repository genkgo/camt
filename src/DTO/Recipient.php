<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

class Recipient implements RelatedPartyTypeInterface
{
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
     * @return null|Address
     */
    public function getAddress(): ?Address
    {
        return $this->address;
    }

    /**
     * @param Address $address
     */
    public function setAddress(Address $address): void
    {
        $this->address = $address;
    }

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return null|string
     */
    public function getCountryOfResidence(): ?string
    {
        return $this->countryOfResidence;
    }

    /**
     * @param string $countryOfResidence
     */
    public function setCountryOfResidence(string $countryOfResidence): void
    {
        $this->countryOfResidence = $countryOfResidence;
    }

    /**
     * @return null|ContactDetails
     */
    public function getContactDetails():?ContactDetails
    {
        return $this->contactDetails;
    }

    /**
     * @param ContactDetails $contactDetails
     */
    public function setContactDetails(ContactDetails $contactDetails): void
    {
        $this->contactDetails = $contactDetails;
    }

    /**
     * @return null|Identification
     */
    public function getIdentification():?Identification
    {
        return $this->identification;
    }

    /**
     * @param Identification $identification
     */
    public function setIdentification(Identification $identification): void
    {
        $this->identification = $identification;
    }
}
