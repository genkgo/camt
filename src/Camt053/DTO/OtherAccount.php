<?php

namespace Genkgo\Camt\Camt053\DTO;

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
     * @var string|null
     */
    private $schemeName;

    /**
     * @var string|null
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
     * @return string|null
     */
    public function getSchemeName()
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
     * @return string|null
     */
    public function getIssuer()
    {
        return $this->issuer;
    }
}
