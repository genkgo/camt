<?php

namespace Genkgo\Camt\DTO;

class ContactDetails
{
    /**
     * @var string|null
     */
    private $namePrefix;

    /**
     * @var string|null
     */
    private $name;

    /**
     * @var string|null
     */
    private $phoneNumber;

    /**
     * @var string|null
     */
    private $mobileNumber;

    /**
     * @var string|null
     */
    private $faxNumber;

    /**
     * @var string|null
     */
    private $emailAddress;

    /**
     * @var string|null
     */
    private $other;

    /**
     * @return string|null
     */
    public function getNamePrefix()
    {
        return $this->namePrefix;
    }
    
    /**
     * @param string $namePrefix
     */
    public function setNamePrefix($namePrefix)
    {
        $this->namePrefix = $namePrefix;
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
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }
    
    /**
     * @param string $name
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return string|null
     */
    public function getMobileNumber()
    {
        return $this->mobileNumber;
    }
    
    /**
     * @param string $name
     */
    public function setMobileNumber($mobileNumber)
    {
        $this->mobileNumber = $mobileNumber;
    }

    /**
     * @return string|null
     */
    public function getFaxNumber()
    {
        return $this->faxNumber;
    }
    
    /**
     * @param string $name
     */
    public function setFaxNumber($faxNumber)
    {
        $this->faxNumber = $faxNumber;
    }

    /**
     * @return string|null
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }
    
    /**
     * @param string $name
     */
    public function setEmailAddress($emailAddress)
    {
        $this->emailAddress = $emailAddress;
    }

    /**
     * @return string|null
     */
    public function getOther()
    {
        return $this->other;
    }
    
    /**
     * @param string $name
     */
    public function setOther($other)
    {
        $this->other = $other;
    }
}
