<?php

namespace Genkgo\Camt\DTO;

use Money\Money;

class Charges
{
    /** @var Money */
    private $totalChargesAndTaxAmount;

    /** @var ChargesRecord[] */
    private $records = [];

    /**
     * @return Money
     */
    public function getTotalChargesAndTaxAmount(): Money
    {
        return $this->totalChargesAndTaxAmount;
    }

    /**
     * @param Money $money
     */
    public function setTotalChargesAndTaxAmount(Money $money): void
    {
        $this->totalChargesAndTaxAmount = $money;
    }

    /**
     * @param ChargesRecord $record
     */
    public function addRecord(ChargesRecord $record): void
    {
        $this->records[] = $record;
    }

    /**
     * @return ChargesRecord[]
     */
    public function getRecords(): array
    {
        return $this->records;
    }

    /**
     * @return null|ChargesRecord
     */
    public function getRecord(): ?ChargesRecord
    {
        if (isset($this->records[0])) {
            return $this->records[0];
        }

        return null;
    }
}
