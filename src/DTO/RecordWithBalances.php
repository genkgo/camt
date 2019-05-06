<?php

namespace Genkgo\Camt\DTO;

/**
 * Class RecordWithBalances
 *
 * @package Genkgo\Camt\DTO
 */
abstract class RecordWithBalances extends Record
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
