<?php

namespace Genkgo\Camt\DTO;

/**
 * Class Debtor
 * @package Genkgo\Camt\DTO
 */
class Debtor implements RelatedPartyTypeInterface
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var Address
     */
    private $address;

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @param Address $address
     */
    public function setAddress(Address $address)
    {
        $this->address = $address;
    }

    /**
     * @return Address|null
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
