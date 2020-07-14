<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

use Money\Money;

class ChargesRecord
{
    /**
     * @var Money
     */
    private $amount;

    /**
     * @var bool
     */
    private $chargesIncludedIndicator = false;

    /**
     * @var string
     */
    private $identification;

    public function getAmount(): Money
    {
        return $this->amount;
    }

    public function setAmount(Money $money): void
    {
        $this->amount = $money;
    }

    public function getChargesIncludedIndicator(): bool
    {
        return $this->chargesIncludedIndicator;
    }

    public function setChargesIncludedIndicator(bool $chargesIncludedIndicator): void
    {
        $this->chargesIncludedIndicator = $chargesIncludedIndicator;
    }

    public function getIdentification(): string
    {
        return $this->identification;
    }

    public function setIdentification(string $identification): void
    {
        $this->identification = $identification;
    }
}
