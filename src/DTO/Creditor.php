<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

class Creditor implements RelatedPartyTypeInterface
{
    private string $name;

    private ?Address $address = null;

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
