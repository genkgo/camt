<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

use DateTimeImmutable;
use Money\Money;

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

    public function __construct(Record $record, int $index, Money $amount)
    {
        $this->record = $record;
        $this->index = $index;
        $this->amount = $amount;
    }

    public function getRecord(): Record
    {
        return $this->record;
    }

    public function getAmount(): Money
    {
        return $this->amount;
    }

    public function getBookingDate(): ?DateTimeImmutable
    {
        return $this->bookingDate;
    }

    public function getValueDate(): ?DateTimeImmutable
    {
        return $this->valueDate;
    }

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

    public function getTransactionDetail(): ?EntryTransactionDetail
    {
        if (isset($this->transactionDetails[0])) {
            return $this->transactionDetails[0];
        }

        return null;
    }

    public function getReversalIndicator(): bool
    {
        return $this->reversalIndicator;
    }

    public function setReversalIndicator(bool $reversalIndicator): void
    {
        $this->reversalIndicator = $reversalIndicator;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): void
    {
        $this->reference = $reference;
    }

    /**
     * Unique reference as assigned by the account servicing institution to unambiguously identify the entry.
     */
    public function getAccountServicerReference(): ?string
    {
        return $this->accountServicerReference;
    }

    public function setAccountServicerReference(?string $accountServicerReference): void
    {
        $this->accountServicerReference = $accountServicerReference;
    }

    public function getIndex(): int
    {
        return $this->index;
    }

    public function setBatchPaymentId(?string $batchPaymentId): void
    {
        $this->batchPaymentId = trim((string) $batchPaymentId);
    }

    public function getBatchPaymentId(): ?string
    {
        return $this->batchPaymentId;
    }

    public function getAdditionalInfo(): ?string
    {
        return $this->additionalInfo;
    }

    public function setAdditionalInfo(?string $additionalInfo): void
    {
        $this->additionalInfo = $additionalInfo;
    }

    public function getBankTransactionCode(): ?BankTransactionCode
    {
        return $this->bankTransactionCode;
    }

    public function setBankTransactionCode(?BankTransactionCode $bankTransactionCode): void
    {
        $this->bankTransactionCode = $bankTransactionCode;
    }

    public function getCharges(): ?Charges
    {
        return $this->charges;
    }

    public function setCharges(?Charges $charges): void
    {
        $this->charges = $charges;
    }

    public function setBookingDate(?DateTimeImmutable $date): void
    {
        $this->bookingDate = $date;
    }

    public function setValueDate(?DateTimeImmutable $date): void
    {
        $this->valueDate = $date;
    }
}
