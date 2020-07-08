<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

class Creditor implements RelatedPartyTypeInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var null|Address
     */
    private $address;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function setAddress(Address $address): void
    {
        $this->address = $address;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function getName(): ?string
    {
        return $this->name;
    }
}
