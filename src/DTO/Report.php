<?php

namespace Genkgo\Camt\DTO;

/**
 * Class Report
 * @package Genkgo\Camt\DTO
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
