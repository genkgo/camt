<?php

namespace Genkgo\Camt\DTO;

/**
 * Class BBANAccount
 * @package Genkgo\Camt
 */
class BBANAccount extends Account
{
    /**
     * @var string
     */
    private $bban;

    /**
     * @param string $bban
     */
    public function __construct($bban)
    {
        $this->bban = $bban;
    }

    /**
     * @return string
     */
    public function getBban()
    {
        return (string) $this->bban;
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentification()
    {
        return (string) $this->bban;
    }
}
