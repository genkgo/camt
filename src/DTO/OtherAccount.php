<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

class OtherAccount extends Account
{
    private string $identification;

    private ?string $schemeName = null;

    private ?string $issuer = null;

    public function __construct(string $identification)
    {
        $this->identification = $identification;
    }

    /**
     * @inheritDoc
     */
    public function getIdentification(): string
    {
        return $this->identification;
    }

    public function setSchemeName(string $schemeName): void
    {
        $this->schemeName = $schemeName;
    }

    public function getSchemeName(): ?string
    {
        return $this->schemeName;
    }

    public function setIssuer(string $issuer): void
    {
        $this->issuer = $issuer;
    }

    public function getIssuer(): ?string
    {
        return $this->issuer;
    }
}
