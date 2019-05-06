<?php

namespace Genkgo\Camt\DTO;

class Recipient implements RelatedPartyTypeInterface
{
    /**
     * @var Address|null
     */
    private $address;

    /**
     * @var string|null
     */
    private $name;

    /**
     * @var string|null
     */
    private $countryOfResidence;

    /**
     * @var ContactDetails|null
     */
    private $contactDetails;

    /**
     * @var Identification|null
     */
    private $identification;

    /**
     * @return Address|null
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param Address $address
     */
    public function setAddress(Address $address)
    {
        $this->address = $address;
    }

    /**
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getCountryOfResidence()
    {
        return $this->countryOfResidence;
    }

    /**
     * @param string $countryOfResidence
     */
    public function setCountryOfResidence($countryOfResidence)
    {
        $this->countryOfResidence = $countryOfResidence;
    }

    /**
     * @return ContactDetails|null
     */
    public function getContactDetails()
    {
        return $this->contactDetails;
    }

    /**
     * @param ContactDetails $contactDetails
     */
    public function setContactDetails(ContactDetails $contactDetails)
    {
        $this->contactDetails = $contactDetails;
    }

    /**
     * @return Identification|null
     */
    public function getIdentification()
    {
        return $this->identification;
    }

    /**
     * @param Identification $identification
     */
    public function setIdentification(Identification $identification)
    {
        $this->identification = $identification;
    }
}
