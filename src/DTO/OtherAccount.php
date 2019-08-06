<?php

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
    public function __construct($identification)
    {
        $this->identification = $identification;
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentification()
    {
        return $this->identification;
    }

    /**
     * @param string $schemeName
     */
    public function setSchemeName($schemeName)
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
    public function setIssuer($issuer)
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
