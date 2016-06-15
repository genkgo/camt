<?php

namespace Genkgo\Camt\DTO;

/**
 * Class Address
 * @package Genkgo\Camt\DTO
 */
class Address
{
    /**
     * @var string|null
     */
    private $country;

    /**
     * @var string|null
     */
    private $countrySubDivision;

    /**
     * @var array
     */
    private $addressLines = [];

    /**
     * @var string|null
     */
    private $department;

    /**
     * @var string|null
     */
    private $subDepartment;

    /**
     * @var string|null
     */
    private $streetName;

    /**
     * @var string|null
     */
    private $buildingNumber;

    /**
     * @var string|null
     */
    private $postCode;

    /**
     * @var string|null
     */
    private $townName;

    /**
     * @return string|null
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param  string $country
     *
     * @return static
     */
    public function setCountry($country)
    {
        $cloned = clone $this;
        $cloned->country = $country;

        return $cloned;
    }

    /**
     * @return string|null
     */
    public function getCountrySubDivision()
    {
        return $this->countrySubDivision;
    }

    /**
     * @param  string $countrySubDivision
     *
     * @return static
     */
    public function setCountrySubDivision($countrySubDivision)
    {
        $cloned = clone $this;
        $cloned->countrySubDivision = $countrySubDivision;

        return $cloned;
    }

    /**
     * @return array
     */
    public function getAddressLines()
    {
        return $this->addressLines;
    }

    /**
     * @param  array $addressLines
     *
     * @return static
     */
    public function setAddressLines(array $addressLines)
    {
        $cloned = clone $this;
        $cloned->addressLines = $addressLines;

        return $cloned;
    }

    /**
     * @param  string $addressLine
     *
     * @return static
     */
    public function addAddressLine($addressLine)
    {
        $cloned = clone $this;
        $cloned->addressLines[] = $addressLine;

        return $cloned;
    }

    /**
     * @return string|null
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * @param  string $department
     *
     * @return static
     */
    public function setDepartment($department)
    {
        $cloned = clone $this;
        $cloned->department = $department;

        return $cloned;
    }

    /**
     * @return string|null
     */
    public function getSubDepartment()
    {
        return $this->subDepartment;
    }

    /**
     * @param  string $subDepartment
     *
     * @return static
     */
    public function setSubDepartment($subDepartment)
    {
        $cloned = clone $this;
        $cloned->subDepartment = $subDepartment;

        return $cloned;
    }

    /**
     * @return string|null
     */
    public function getStreetName()
    {
        return $this->streetName;
    }

    /**
     * @param  string $streetName
     *
     * @return static
     */
    public function setStreetName($streetName)
    {
        $cloned = clone $this;
        $cloned->streetName = $streetName;

        return $cloned;
    }

    /**
     * @return string|null
     */
    public function getBuildingNumber()
    {
        return $this->buildingNumber;
    }

    /**
     * @param  string $buildingNumber
     *
     * @return static
     */
    public function setBuildingNumber($buildingNumber)
    {
        $cloned = clone $this;
        $cloned->buildingNumber = $buildingNumber;

        return $cloned;
    }

    /**
     * @return string|null
     */
    public function getPostCode()
    {
        return $this->postCode;
    }

    /**
     * @param  string $postCode
     *
     * @return static
     */
    public function setPostCode($postCode)
    {
        $cloned = clone $this;
        $cloned->postCode = $postCode;

        return $cloned;
    }

    /**
     * @return string|null
     */
    public function getTownName()
    {
        return $this->townName;
    }

    /**
     * @param  string $townName
     *
     * @return static
     */
    public function setTownName($townName)
    {
        $cloned = clone $this;
        $cloned->townName = $townName;

        return $cloned;
    }
}
