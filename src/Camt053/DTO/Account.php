<?php

namespace Genkgo\Camt\Camt053\DTO;

use Genkgo\Camt\Iban;

/**
 * Class Account
 * @package Genkgo\Camt\Camt053
 */
class Account
{
    /**
     * @var Iban
     */
    private $iban;

    public function __construct(Iban $iban)
    {
        $this->iban = $iban;
    }

    /**
     * @return Iban
     */
    public function getIban()
    {
        return $this->iban;
    }
}
