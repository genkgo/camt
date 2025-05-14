<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

use DateTimeImmutable;

class PrivateIdentification extends Identification
{
    private ?DateTimeImmutable $birthDate = null;

    private ?string $provinceOfBirth = null;

    private ?string $cityOfBirth = null;

    private ?string $countryOfBirth = null;

    private ?string $otherId = null;

    private ?string $otherIssuer = null;

    private ?string $otherSchemeName = null;

    public function getBirthDate(): ?DateTimeImmutable
    {
        return $this->birthDate;
    }

    public function setBirthDate(?DateTimeImmutable $birthDate): void
    {
        $this->birthDate = $birthDate;
    }

    public function getProvinceOfBirth(): ?string
    {
        return $this->provinceOfBirth;
    }

    public function setProvinceOfBirth(?string $provinceOfBirth): void
    {
        $this->provinceOfBirth = $provinceOfBirth;
    }

    public function getCityOfBirth(): ?string
    {
        return $this->cityOfBirth;
    }

    public function setCityOfBirth(?string $cityOfBirth): void
    {
        $this->cityOfBirth = $cityOfBirth;
    }

    public function getCountryOfBirth(): ?string
    {
        return $this->countryOfBirth;
    }

    public function setCountryOfBirth(?string $countryOfBirth): void
    {
        $this->countryOfBirth = $countryOfBirth;
    }

    public function getOtherId(): ?string
    {
        return $this->otherId;
    }

    public function setOtherId(?string $otherId): void
    {
        $this->otherId = $otherId;
    }

    public function getOtherIssuer(): ?string
    {
        return $this->otherIssuer;
    }

    public function setOtherIssuer(?string $otherIssuer): void
    {
        $this->otherIssuer = $otherIssuer;
    }

    public function getOtherSchemeName(): ?string
    {
        return $this->otherSchemeName;
    }

    public function setOtherSchemeName(?string $otherSchemeName): void
    {
        $this->otherSchemeName = $otherSchemeName;
    }
}
