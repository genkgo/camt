<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

/**
 * Class Creditor
 * @package Genkgo\Camt\DTO
 */
class Creditor implements RelatedPartyTypeInterface
{
    /**
     * @var string|null
     */
    private $id;
    /**
     * @var string
     */
    private $name;
    /**
     * @var null|Address
     */
    private $address;
    /**
     * @var string|null
     */
    private $typeName;

    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @param Address $address
     */
    public function setAddress(Address $address): void
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

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getTypeName(): ?string
    {
        return $this->typeName;
    }

    /**
     * @param string|null $typeName
     */
    public function setTypeName(?string $typeName): void
    {
        $this->typeName = $typeName;
    }
}
