<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

class Debtor implements RelatedPartyTypeInterface
{
    private ?Address $address = null;

    public function __construct(private ?string $name)
    {
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
