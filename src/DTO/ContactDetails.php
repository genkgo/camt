<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

class ContactDetails
{
    /**
     * @var null|string
     */
    private $namePrefix;

    /**
     * @var null|string
     */
    private $name;

    /**
     * @var null|string
     */
    private $phoneNumber;

    /**
     * @var null|string
     */
    private $mobileNumber;

    /**
     * @var null|string
     */
    private $faxNumber;

    /**
     * @var null|string
     */
    private $emailAddress;

    /**
     * @var null|string
     */
    private $other;

    public function getNamePrefix(): ?string
    {
        return $this->namePrefix;
    }

    public function setNamePrefix(string $namePrefix): void
    {
        $this->namePrefix = $namePrefix;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function getMobileNumber(): ?string
    {
        return $this->mobileNumber;
    }

    public function setMobileNumber(string $mobileNumber): void
    {
        $this->mobileNumber = $mobileNumber;
    }

    public function getFaxNumber(): ?string
    {
        return $this->faxNumber;
    }

    public function setFaxNumber(string $faxNumber): void
    {
        $this->faxNumber = $faxNumber;
    }

    public function getEmailAddress(): ?string
    {
        return $this->emailAddress;
    }

    public function setEmailAddress(string $emailAddress): void
    {
        $this->emailAddress = $emailAddress;
    }

    public function getOther(): ?string
    {
        return $this->other;
    }

    public function setOther(string $other): void
    {
        $this->other = $other;
    }
}
