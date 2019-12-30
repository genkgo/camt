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
    public function __construct(string $upic)
    {
        $this->upic = $upic;
    }

    /**
     * @return string
     */
    public function getUpic(): string
    {
        return (string) $this->upic;
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentification(): string
    {
        return (string) $this->upic;
    }
}
