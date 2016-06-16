<?php

namespace Genkgo\Camt\Camt052\DTO;

use Genkgo\Camt\DTO\Account;

/**
 * Class BBANAccount
 * @package Genkgo\Camt\Camt052
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
