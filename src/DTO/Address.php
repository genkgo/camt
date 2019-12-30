<?php

namespace Genkgo\Camt\DTO;

/**
 * Class Address
 * @package Genkgo\Camt\DTO
 */
class Address
{
    /**
     * @var null|string
     */
    private $country;

    /**
     * @var null|string
     */
    private $countrySubDivision;

    /**
     * @var array
     */
    private $addressLines = [];

    /**
     * @var null|string
     */
    private $department;

    /**
     * @var null|string
     */
    private $subDepartment;

    /**
     * @var null|string
     */
    private $streetName;

    /**
     * @var null|string
     */
    private $buildingNumber;

    /**
     * @var null|string
     */
    private $postCode;

    /**
     * @var null|string
     */
    private $townName;

    /**
     * @return null|string
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @param  string $country
     *
     * @return static
     */
    public function setCountry(string $country): self
    {
        $cloned = clone $this;
        $cloned->country = $country;

        return $cloned;
    }

    /**
     * @return null|string
     */
    public function getCountrySubDivision(): ?string
    {
        return $this->countrySubDivision;
    }

    /**
     * @param  string $countrySubDivision
     *
     * @return static
     */
    public function setCountrySubDivision(string $countrySubDivision): self
    {
        $cloned = clone $this;
        $cloned->countrySubDivision = $countrySubDivision;

        return $cloned;
    }

    /**
     * @return array
     */
    public function getAddressLines(): array
    {
        return $this->addressLines;
    }

    /**
     * @param  array $addressLines
     *
     * @return static
     */
    public function setAddressLines(array $addressLines): self
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
    public function addAddressLine(string $addressLine): self
    {
        $cloned = clone $this;
        $cloned->addressLines[] = $addressLine;

        return $cloned;
    }

    /**
     * @return null|string
     */
    public function getDepartment(): ?string
    {
        return $this->department;
    }

    /**
     * @param  string $department
     *
     * @return static
     */
    public function setDepartment(string $department): self
    {
        $cloned = clone $this;
        $cloned->department = $department;

        return $cloned;
    }

    /**
     * @return null|string
     */
    public function getSubDepartment(): ?string
    {
        return $this->subDepartment;
    }

    /**
     * @param  string $subDepartment
     *
     * @return static
     */
    public function setSubDepartment(string $subDepartment): self
    {
        $cloned = clone $this;
        $cloned->subDepartment = $subDepartment;

        return $cloned;
    }

    /**
     * @return null|string
     */
    public function getStreetName(): ?string
    {
        return $this->streetName;
    }

    /**
     * @param  string $streetName
     *
     * @return static
     */
    public function setStreetName(string $streetName): self
    {
        $cloned = clone $this;
        $cloned->streetName = $streetName;

        return $cloned;
    }

    /**
     * @return null|string
     */
    public function getBuildingNumber(): ?string
    {
        return $this->buildingNumber;
    }

    /**
     * @param  string $buildingNumber
     *
     * @return static
     */
    public function setBuildingNumber(string $buildingNumber): self
    {
        $cloned = clone $this;
        $cloned->buildingNumber = $buildingNumber;

        return $cloned;
    }

    /**
     * @return null|string
     */
    public function getPostCode(): ?string
    {
        return $this->postCode;
    }

    /**
     * @param  string $postCode
     *
     * @return static
     */
    public function setPostCode(string $postCode): self
    {
        $cloned = clone $this;
        $cloned->postCode = $postCode;

        return $cloned;
    }

    /**
     * @return null|string
     */
    public function getTownName(): ?string
    {
        return $this->townName;
    }

    /**
     * @param  string $townName
     *
     * @return static
     */
    public function setTownName(string $townName): self
    {
        $cloned = clone $this;
        $cloned->townName = $townName;

        return $cloned;
    }
}
