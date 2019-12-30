<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

/**
 * Class OtherAccount
 * @package Genkgo\Camt\Camt053
 */
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

    /**
     * @param string $identification
     */
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

    /**
     * @param string $schemeName
     */
    public function setSchemeName(string $schemeName): void
    {
        $this->schemeName = $schemeName;
    }

    /**
     * @return null|string
     */
    public function getSchemeName(): ?string
    {
        return $this->schemeName;
    }

    /**
     * @param string $issuer
     */
    public function setIssuer(string $issuer): void
    {
        $this->issuer = $issuer;
    }

    /**
     * @return null|string
     */
    public function getIssuer(): ?string
    {
        return $this->issuer;
    }
}
