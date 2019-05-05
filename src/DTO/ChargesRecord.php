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
    private $chargesIncluded­Indicator = false;
    
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
     * @return ChargesIncluded­Indicator
     */
    public function getChargesIncluded­Indicator()
    {
        return $this->chargesIncluded­Indicator;
    }

    /**
     * @param $chargesIncluded­Indicator
     */
    public function setChargesIncluded­Indicator($chargesIncluded­Indicator)
    {
        $this->chargesIncluded­Indicator = $chargesIncluded­Indicator;
    }

    /**
     * @return Identification
     */
    public function getIdentification()
    {
        return $this->identification;
    }

    /**
     * @param $identification
     */
    public function setIdentification($identification)
    {
        $this->identification = $identification;
    }
}
