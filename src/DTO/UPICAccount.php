<?php

namespace Genkgo\Camt\DTO;

/**
 * Class UPICAccount
 * @package Genkgo\Camt\Camt052
 */
class UPICAccount extends Account
{
    /**
     * @var string
     */
    private $upic;

    /**
     * @param string $upic
     */
    public function __construct($upic)
    {
        $this->upic = $upic;
    }

    /**
     * @return string
     */
    public function getUpic()
    {
        return (string) $this->upic;
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentification()
    {
        return (string) $this->upic;
    }
}
