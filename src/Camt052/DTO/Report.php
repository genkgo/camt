<?php

namespace Genkgo\Camt\Camt052\DTO;

use Genkgo\Camt\DTO\Record;
use Genkgo\Camt\DTO\Balance;

/**
 * Class Report
 * @package Genkgo\Camt\Camt052
 */
class Report extends Record
{
    /**
     * @var array
     */
    private $balances = [];

    /**
     * @param Balance $balance
     */
    public function addBalance(Balance $balance)
    {
        $this->balances[] = $balance;
    }

    /**
     * @return Balance[]
     */
    public function getBalances()
    {
        return $this->balances;
    }
}
