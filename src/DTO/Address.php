<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

class Address
{
    private ?string $country = null;

    private ?string $countrySubDivision = null;

    /**
     * @var string[]
     */
    private array $addressLines = [];

    private ?string $department = null;

    private ?string $subDepartment = null;

    private ?string $streetName = null;

    private ?string $buildingNumber = null;

    private ?string $postCode = null;

    private ?string $townName = null;

    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @return static
     */
    public function setCountry(string $country): self
    {
        $cloned = clone $this;
        $cloned->country = $country;

        return $cloned;
    }

    public function getCountrySubDivision(): ?string
    {
        return $this->countrySubDivision;
    }

    /**
     * @return static
     */
    public function setCountrySubDivision(string $countrySubDivision): self
    {
        $cloned = clone $this;
        $cloned->countrySubDivision = $countrySubDivision;

        return $cloned;
    }

    /**
     * @return string[]
     */
    public function getAddressLines(): array
    {
        return $this->addressLines;
    }

    /**
     * @param string[] $addressLines
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
     * @return static
     */
    public function addAddressLine(string $addressLine): self
    {
        $cloned = clone $this;
        $cloned->addressLines[] = $addressLine;

        return $cloned;
    }

    public function getDepartment(): ?string
    {
        return $this->department;
    }

    /**
     * @return static
     */
    public function setDepartment(string $department): self
    {
        $cloned = clone $this;
        $cloned->department = $department;

        return $cloned;
    }

    public function getSubDepartment(): ?string
    {
        return $this->subDepartment;
    }

    /**
     * @return static
     */
    public function setSubDepartment(string $subDepartment): self
    {
        $cloned = clone $this;
        $cloned->subDepartment = $subDepartment;

        return $cloned;
    }

    public function getStreetName(): ?string
    {
        return $this->streetName;
    }

    /**
     * @return static
     */
    public function setStreetName(string $streetName): self
    {
        $cloned = clone $this;
        $cloned->streetName = $streetName;

        return $cloned;
    }

    public function getBuildingNumber(): ?string
    {
        return $this->buildingNumber;
    }

    /**
     * @return static
     */
    public function setBuildingNumber(string $buildingNumber): self
    {
        $cloned = clone $this;
        $cloned->buildingNumber = $buildingNumber;

        return $cloned;
    }

    public function getPostCode(): ?string
    {
        return $this->postCode;
    }

    /**
     * @return static
     */
    public function setPostCode(string $postCode): self
    {
        $cloned = clone $this;
        $cloned->postCode = $postCode;

        return $cloned;
    }

    public function getTownName(): ?string
    {
        return $this->townName;
    }

    /**
     * @return static
     */
    public function setTownName(string $townName): self
    {
        $cloned = clone $this;
        $cloned->townName = $townName;

        return $cloned;
    }
}
