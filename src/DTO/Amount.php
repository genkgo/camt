<?php

namespace Genkgo\Camt\DTO;

use Money\Money;

/**
 * Class Amount
 * @package Genkgo\Camt\DTO
 */
class Amount
{
    /**
     * @var Money
     */
    private $amount;

    /**
     * @return Money
     */
    public function getAmount()
    {
        return $this->amount;  
    }

    /**
     * @param Money $money
     */
    public function setAmount(Money $money)
    {
        $this->amount = $money;
    }

}
