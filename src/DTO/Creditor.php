<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

class Creditor implements RelatedPartyTypeInterface
{
    private ?Address $address = null;
    private ?string $orgId;

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

    public function setOrgId(?string $orgId): void
    {
        $this->orgId = $orgId;
    }

    public function getOrgId(): ?string
    {
        return $this->orgId;
    }
}
