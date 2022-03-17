<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

abstract class RecordWithBalances extends Record
{
    /**
     * @var Balance[]
     */
    private array $balances = [];

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
