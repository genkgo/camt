<?php

namespace Genkgo\Camt\DTO;

/**
 * Class Creditor
 * @package Genkgo\Camt\DTO
 */
class Creditor implements RelatedPartyTypeInterface
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
     * @return null|Address
     */
    public function getAddress(): ?Address
    {
        return $this->address;
    }

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }
}
