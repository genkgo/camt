<?php

namespace Genkgo\Camt\DTO;

use DateTimeImmutable;

class PersonIdentification extends Identification
{
    /**
     * @var string|null
     */
    private $driversLicenseNumber;

    /**
     * @var string|null
     */
    private $customerNumber;

    /**
     * @var string|null
     */
    private $socialSecurityNumber;

    /**
     * @var string|null
     */
    private $alienRegistrationNumber;

    /**
     * @var string|null
     */
    private $passportNumber;

    /**
     * @var string|null
     */
    private $taxId;

    /**
     * @var string|null
     */
    private $idCardNumber;

    /**
     * @var string|null
     */
    private $employerId;

    /**
     * @var string|null
     */
    private $issuer;

    /**
     * @var DateTimeImmutable|null
     */
    private $birthDate;

    /**
     * @var string|null
     */
    private $provinceOfBirth;

    /**
     * @var string|null
     */
    private $cityOfBirth;

    /**
     * @var string|null
     */
    private $countryOfBirth;

    /**
     * @var string|null
     */
    private $otherIdentification;

    /**
     * @var string|null
     */
    private $otherIdentificationType;

    /**
     * @var string|null
     */
    private $otherIdentificationSchemeName;

    /**
     * @var string|null
     */
    private $otherIdentificationIssuer;

    /**
     * @return string|null
     */
    public function getDriversLicenseNumber()
    {
        return $this->driversLicenseNumber;
    }
    
    /**
     * @param string $driversLicenseNumber
     */
    public function setDriversLicenseNumber($driversLicenseNumber)
    {
        $this->driversLicenseNumber = $driversLicenseNumber;
        $this->identification = $driversLicenseNumber;
    }

    /**
     * @return string|null
     */
    public function getCustomerNumber()
    {
        return $this->customerNumber;
    }
    
    /**
     * @param string $customerNumber
     */
    public function setCustomerNumber($customerNumber)
    {
        $this->customerNumber = $customerNumber;
        $this->identification = $customerNumber;
    }

    /**
     * @return string|null
     */
    public function getSocialSecurityNumber()
    {
        return $this->socialSecurityNumber;
    }
    
    /**
     * @param string $socialSecurityNumber
     */
    public function setSocialSecurityNumber($socialSecurityNumber)
    {
        $this->socialSecurityNumber = $socialSecurityNumber;
        $this->identification = $socialSecurityNumber;
    }

    /**
     * @return string|null
     */
    public function getAlienRegistrationNumber()
    {
        return $this->alienRegistrationNumber;
    }
    
    /**
     * @param string $alienRegistrationNumber
     */
    public function setAlienRegistrationNumber($alienRegistrationNumber)
    {
        $this->alienRegistrationNumber = $alienRegistrationNumber;
        $this->identification = $alienRegistrationNumber;
    }

    /**
     * @return string|null
     */
    public function getPassportNumber()
    {
        return $this->passportNumber;
    }
    
    /**
     * @param string $passportNumber
     */
    public function setPassportNumber($passportNumber)
    {
        $this->passportNumber = $passportNumber;
        $this->identification = $passportNumber;
    }

    /**
     * @return string|null
     */
    public function getTaxId()
    {
        return $this->taxId;
    }
    
    /**
     * @param string $taxId
     */
    public function setTaxId($taxId)
    {
        $this->taxId = $taxId;
        $this->identification = $taxId;
    }

    /**
     * @return string|null
     */
    public function getIdCardNumber()
    {
        return $this->idCardNumber;
    }
    
    /**
     * @param string $idCardNumber
     */
    public function setIdCardNumber($idCardNumber)
    {
        $this->idCardNumber = $idCardNumber;
        $this->identification = $idCardNumber;
    }

    /**
     * @return string|null
     */
    public function getEmployerId()
    {
        return $this->employerId;
    }
    
    /**
     * @param string $employerId
     */
    public function setEmployerId($employerId)
    {
        $this->employerId = $employerId;
        $this->identification = $employerId;
    }

    /**
     * @return string|null
     */
    public function getIssuer()
    {
        return $this->issuer;
    }
    
    /**
     * @param string $issuer
     */
    public function setIssuer($issuer)
    {
        $this->issuer = $issuer;
        $this->identification = $issuer;
    }

    /**
     * @return DateTimeImmutable|null
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }
    
    /**
     * @param DateTimeImmutable $birthDate
     */
    public function setBirthDate(DateTimeImmutable $birthDate)
    {
        $this->birthDate = $birthDate;
    }

    /**
     * @return string|null
     */
    public function getProvinceOfBirth()
    {
        return $this->provinceOfBirth;
    }
    
    /**
     * @param string $provinceOfBirth
     */
    public function setProvinceOfBirth($provinceOfBirth)
    {
        $this->provinceOfBirth = $provinceOfBirth;
    }

    /**
     * @return string|null
     */
    public function getCityOfBirth()
    {
        return $this->cityOfBirth;
    }
    
    /**
     * @param string $cityOfBirth
     */
    public function setCityOfBirth($cityOfBirth)
    {
        $this->cityOfBirth = $cityOfBirth;
    }

    /**
     * @return string|null
     */
    public function getCountryOfBirth()
    {
        return $this->countryOfBirth;
    }
    
    /**
     * @param string $countryOfBirth
     */
    public function setCountryOfBirth($countryOfBirth)
    {
        $this->countryOfBirth = $countryOfBirth;
    }

    /**
     * @return string|null
     */
    public function getOtherIdentification()
    {
        return $this->otherIdentification;
    }
    
    /**
     * @param string $otherIdentification
     */
    public function setOtherIdentification($otherIdentification)
    {
        $this->otherIdentification = $otherIdentification;
        $this->identification = $otherIdentification;
    }

    /**
     * @return string|null
     */
    public function getOtherIdentificationType()
    {
        return $this->otherIdentificationType;
    }
    
    /**
     * @param string $otherIdentificationType
     */
    public function setOtherIdentificationType($otherIdentificationType)
    {
        $this->otherIdentificationType = $otherIdentificationType;
    }

    /**
     * @return string|null
     */
    public function getOtherIdentificationSchemeName()
    {
        return $this->otherIdentificationSchemeName;
    }
    
    /**
     * @param string $otherIdentificationSchemeName
     */
    public function setOtherIdentificationSchemeName($otherIdentificationSchemeName)
    {
        $this->otherIdentificationSchemeName = $otherIdentificationSchemeName;
    }

    /**
     * @return string|null
     */
    public function getOtherIdentificationIssuer()
    {
        return $this->otherIdentificationIssuer;
    }
    
    /**
     * @param string $otherIdentificationIssuer
     */
    public function setOtherIdentificationIssuer($otherIdentificationIssuer)
    {
        $this->otherIdentificationIssuer = $otherIdentificationIssuer;
    }
}
