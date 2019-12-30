<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

/**
 * Class RecordWithBalances
 *
 * @package Genkgo\Camt\DTO
 */
abstract class RecordWithBalances extends Record
{
    /**
     * @var Balance[]
     */
    private $balances = [];

    /**
     * @param Balance $balance
     */
    public function addBalance(Balance $balance): void
    {
        $this->balances[] = $balance;
    }

    /**
     * @return Balance[]
     */
    public function getBalances(): array
    {
        return $this->balances;
    }
}
