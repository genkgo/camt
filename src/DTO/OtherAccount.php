<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

class OtherAccount extends Account
{
    /**
     * @var string
     */
    private $identification;

    /**
     * @var null|string
     */
    private $schemeName;

    /**
     * @var null|string
     */
    private $issuer;

    public function __construct(string $identification)
    {
        $this->identification = $identification;
    }

    /**
     * {@inheritdoc}
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
