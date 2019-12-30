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
    public function __construct(Record $record, int $index, Money $amount)
    {
        $this->record = $record;
        $this->index = $index;
        $this->amount = $amount;
    }

    /**
     * @return Record
     */
    public function getRecord(): Record
    {
        return $this->record;
    }

    /**
     * @return Money
     */
    public function getAmount(): Money
    {
        return $this->amount;
    }

    /**
     * @return null|DateTimeImmutable
     */
    public function getBookingDate(): ?DateTimeImmutable
    {
        return $this->bookingDate;
    }

    /**
     * @return null|DateTimeImmutable
     */
    public function getValueDate(): ?DateTimeImmutable
    {
        return $this->valueDate;
    }

    /**
     * @param EntryTransactionDetail $detail
     */
    public function addTransactionDetail(EntryTransactionDetail $detail): void
    {
        $this->transactionDetails[] = $detail;
    }

    /**
     * @return EntryTransactionDetail[]
     */
    public function getTransactionDetails(): array
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
    public function getReversalIndicator(): bool
    {
        return $this->reversalIndicator;
    }

    /**
     * @param bool $reversalIndicator
     */
    public function setReversalIndicator(bool $reversalIndicator): void
    {
        $this->reversalIndicator = $reversalIndicator;
    }

    /**
     * @return null|string
     */
    public function getReference(): ?string
    {
        return $this->reference;
    }

    /**
     * @param null|string $reference
     */
    public function setReference(?string $reference): void
    {
        $this->reference = $reference;
    }

    /**
     * Unique reference as assigned by the account servicing institution to unambiguously identify the entry.
     *
     * @return null|string
     */
    public function getAccountServicerReference(): ?string
    {
        return $this->accountServicerReference;
    }

    /**
     * @param null|string $accountServicerReference
     */
    public function setAccountServicerReference(?string $accountServicerReference): void
    {
        $this->accountServicerReference = $accountServicerReference;
    }

    /**
     * @return int
     */
    public function getIndex(): int
    {
        return $this->index;
    }

    /**
     * @param null|string $batchPaymentId
     */
    public function setBatchPaymentId(?string $batchPaymentId): void
    {
        $this->batchPaymentId = trim($batchPaymentId);
    }

    /**
     * @return null|string
     */
    public function getBatchPaymentId(): ?string
    {
        return $this->batchPaymentId;
    }

    /**
     * @return null|string
     */
    public function getAdditionalInfo(): ?string
    {
        return $this->additionalInfo;
    }

    /**
     * @param null|string $additionalInfo
     */
    public function setAdditionalInfo(?string $additionalInfo): void
    {
        $this->additionalInfo = $additionalInfo;
    }

    /**
     * @return null|BankTransactionCode
     */
    public function getBankTransactionCode(): ?BankTransactionCode
    {
        return $this->bankTransactionCode;
    }

    /**
     * @param null|BankTransactionCode $bankTransactionCode
     */
    public function setBankTransactionCode(?BankTransactionCode $bankTransactionCode): void
    {
        $this->bankTransactionCode = $bankTransactionCode;
    }

    /**
     * @return null|Charges
     */
    public function getCharges(): ?Charges
    {
        return $this->charges;
    }

    /**
     * @param null|Charges $charges
     */
    public function setCharges(?Charges $charges): void
    {
        $this->charges = $charges;
    }

    /**
     * @param null|DateTimeImmutable $date
     */
    public function setBookingDate(?DateTimeImmutable $date): void
    {
        $this->bookingDate = $date;
    }

    /**
     * @param null|DateTimeImmutable $date
     */
    public function setValueDate(?DateTimeImmutable $date): void
    {
        $this->valueDate = $date;
    }
}
