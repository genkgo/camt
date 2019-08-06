<?php
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

    /**
     * @return bool
     */
    public function getChargesIncludedIndicator()
    {
        return $this->chargesIncludedIndicator;
    }

    /**
     * @param bool $chargesIncludedIndicator
     */
    public function setChargesIncludedIndicator($chargesIncludedIndicator)
    {
        $this->chargesIncludedIndicator = $chargesIncludedIndicator;
    }

    /**
     * @return string
     */
    public function getIdentification()
    {
        return $this->identification;
    }

    /**
     * @param string $identification
     */
    public function setIdentification($identification)
    {
        $this->identification = $identification;
    }
}
