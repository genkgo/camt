<?php

namespace Genkgo\Camt\DTO;

use DateTimeImmutable;
use Money\Money;

/**
 * Class Entry
 *
 * @package Genkgo\Camt\DTO
 */
class Entry
{
    /**
     * @var Record
     */
    private $record;

    /**
     * @var Money
     */
    private $amount;

    /**
     * @var null|DateTimeImmutable
     */
    private $bookingDate;

    /**
     * @var null|DateTimeImmutable
     */
    private $valueDate;

    /**
     * @var EntryTransactionDetail[]
     */
    private $transactionDetails = [];

    /**
     * @var bool
     */
    private $reversalIndicator = false;

    /**
     * @var null|string
     */
    private $reference;

    /**
     * @var null|string
     */
    private $accountServicerReference;

    /**
     * @var int
     */
    private $index;

    /**
     * @var null|string
     */
    private $batchPaymentId;

    /**
     * @var null|string
     */
    private $additionalInfo;

    /**
     * @var null|BankTransactionCode
     */
    private $bankTransactionCode;

    /**
     * @var null|Charges
     */
    private $charges;

    /**
     * @param Record $record
     * @param int $index
     * @param Money $amount
     */
    public function __construct(Record $record, $index, Money $amount)
    {
        $this->record = $record;
        $this->index = $index;
        $this->amount = $amount;
    }

    /**
     * @return Record
     */
    public function getRecord()
    {
        return $this->record;
    }

    /**
     * @return Money
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return null|DateTimeImmutable
     */
    public function getBookingDate()
    {
        return $this->bookingDate;
    }

    /**
     * @return null|DateTimeImmutable
     */
    public function getValueDate()
    {
        return $this->valueDate;
    }

    /**
     * @param EntryTransactionDetail $detail
     */
    public function addTransactionDetail(EntryTransactionDetail $detail)
    {
        $this->transactionDetails[] = $detail;
    }

    /**
     * @return EntryTransactionDetail[]
     */
    public function getTransactionDetails()
    {
        return $this->transactionDetails;
    }

    /**
     * @return null|EntryTransactionDetail
     */
    public function getTransactionDetail(): ?EntryTransactionDetail
    {
        if (isset($this->transactionDetails[0])) {
            return $this->transactionDetails[0];
        }

        return null;
    }

    /**
     * @return bool
     */
    public function getReversalIndicator()
    {
        return $this->reversalIndicator;
    }

    /**
     * @param bool $reversalIndicator
     */
    public function setReversalIndicator($reversalIndicator)
    {
        $this->reversalIndicator = $reversalIndicator;
    }

    /**
     * @return null|string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param null|string $reference
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
    }

    /**
     * Unique reference as assigned by the account servicing institution to unambiguously identify the entry.
     *
     * @return null|string
     */
    public function getAccountServicerReference()
    {
        return $this->accountServicerReference;
    }

    /**
     * @param null|string $accountServicerReference
     */
    public function setAccountServicerReference($accountServicerReference)
    {
        $this->accountServicerReference = $accountServicerReference;
    }

    /**
     * @return int
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * @param null|string $batchPaymentId
     */
    public function setBatchPaymentId($batchPaymentId)
    {
        $this->batchPaymentId = trim($batchPaymentId);
    }

    /**
     * @return null|string
     */
    public function getBatchPaymentId()
    {
        return $this->batchPaymentId;
    }

    /**
     * @return null|string
     */
    public function getAdditionalInfo()
    {
        return $this->additionalInfo;
    }

    /**
     * @param null|string $additionalInfo
     */
    public function setAdditionalInfo($additionalInfo)
    {
        $this->additionalInfo = $additionalInfo;
    }

    /**
     * @return null|BankTransactionCode
     */
    public function getBankTransactionCode()
    {
        return $this->bankTransactionCode;
    }

    /**
     * @param null|BankTransactionCode $bankTransactionCode
     */
    public function setBankTransactionCode(?BankTransactionCode $bankTransactionCode)
    {
        $this->bankTransactionCode = $bankTransactionCode;
    }

    /**
     * @return null|Charges
     */
    public function getCharges()
    {
        return $this->charges;
    }

    /**
     * @param null|Charges $charges
     */
    public function setCharges(?Charges $charges)
    {
        $this->charges = $charges;
    }

    /**
     * @param null|DateTimeImmutable $date
     */
    public function setBookingDate(?DateTimeImmutable $date)
    {
        $this->bookingDate = $date;
    }

    /**
     * @param null|DateTimeImmutable $date
     */
    public function setValueDate(?DateTimeImmutable $date)
    {
        $this->valueDate = $date;
    }
}
