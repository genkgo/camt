<?php

declare(strict_types=1);
namespace Genkgo\Camt\DTO;

use Money\Money;

class ChargesRecord
{

    /** @var Money */
    private $amount;

    /**
     * @var bool
     */
    private $chargesIncludedIndicator = false;

    /**
     * @var string
     */
    private $identification;


    /**
     * @return Money
     */
    public function getAmount(): Money
    {
        return $this->amount;
    }

    /**
     * @param Money $money
     */
    public function setAmount(Money $money): void
    {
        $this->amount = $money;
    }

    /**
     * @return bool
     */
    public function getChargesIncludedIndicator(): bool
    {
        return $this->chargesIncludedIndicator;
    }

    /**
     * @param bool $chargesIncludedIndicator
     */
    public function setChargesIncludedIndicator(bool $chargesIncludedIndicator): void
    {
        $this->chargesIncludedIndicator = $chargesIncludedIndicator;
    }

    /**
     * @return string
     */
    public function getIdentification(): string
    {
        return $this->identification;
    }

    /**
     * @param string $identification
     */
    public function setIdentification(string $identification): void
    {
        $this->identification = $identification;
    }
}
