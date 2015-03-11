<?php
namespace Genkgo\Camt\Camt053;

use DateTimeImmutable;
use Money\Money;

/**
 * Class Entry
 * @package Genkgo\Camt\Camt053
 */
class Entry {

    /**
     * @var Money
     */
    private $amount;
    /**
     * @var DateTimeImmutable
     */
    private $bookingDate;
    /**
     * @var DateTimeImmutable
     */
    private $valueDate;
    /**
     * @var EntryTransactionDetail[]
     */
    private $transactionDetails = [];

    /**
     * @param Money $amount
     * @param DateTimeImmutable $bookingDate
     * @param DateTimeImmutable $valueDate
     */
    public function __construct(Money $amount, DateTimeImmutable $bookingDate, DateTimeImmutable $valueDate)
    {
        $this->amount = $amount;
        $this->bookingDate = $bookingDate;
        $this->valueDate = $valueDate;
    }

    /**
     * @return Money
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getBookingDate()
    {
        return $this->bookingDate;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getValueDate()
    {
        return $this->valueDate;
    }

    /**
     * @param EntryTransactionDetail $detail
     */
    public function addTransactionDetail (EntryTransactionDetail $detail) {
        $this->transactionDetails[] = $detail;
    }

    /**
     * @return EntryTransactionDetail[]
     */
    public function getTransactionDetails()
    {
        return $this->transactionDetails;
    }

}