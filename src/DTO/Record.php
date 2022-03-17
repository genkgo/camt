<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

use DateTimeImmutable;

abstract class Record
{
    protected string $id;

    protected DateTimeImmutable $createdOn;

    protected Account $account;

    protected ?Pagination $pagination = null;

    protected ?string $electronicSequenceNumber = null;

    protected ?string $legalSequenceNumber = null;

    protected ?string $copyDuplicateIndicator = null;

    protected ?DateTimeImmutable $fromDate = null;

    protected ?DateTimeImmutable $toDate = null;

    /**
     * @var Entry[]
     */
    protected $entries = [];

    protected ?string $additionalInformation = null;

    public function __construct(string $id, DateTimeImmutable $createdOn, Account $account)
    {
        $this->id = $id;
        $this->createdOn = $createdOn;
        $this->account = $account;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getCreatedOn(): DateTimeImmutable
    {
        return $this->createdOn;
    }

    public function getAccount(): Account
    {
        return $this->account;
    }

    public function getPagination(): ?Pagination
    {
        return $this->pagination;
    }

    public function setPagination(Pagination $pagination): void
    {
        $this->pagination = $pagination;
    }

    public function getElectronicSequenceNumber(): ?string
    {
        return $this->electronicSequenceNumber;
    }

    public function setElectronicSequenceNumber(string $electronicSequenceNumber): void
    {
        $this->electronicSequenceNumber = $electronicSequenceNumber;
    }

    public function getLegalSequenceNumber(): ?string
    {
        return $this->legalSequenceNumber;
    }

    public function setLegalSequenceNumber(string $legalSequenceNumber): void
    {
        $this->legalSequenceNumber = $legalSequenceNumber;
    }

    public function getCopyDuplicateIndicator(): ?string
    {
        return $this->copyDuplicateIndicator;
    }

    public function setCopyDuplicateIndicator(string $copyDuplicateIndicator): void
    {
        $this->copyDuplicateIndicator = $copyDuplicateIndicator;
    }

    public function getFromDate(): ?DateTimeImmutable
    {
        return $this->fromDate;
    }

    public function setFromDate(DateTimeImmutable $fromDate): void
    {
        $this->fromDate = $fromDate;
    }

    public function getToDate(): ?DateTimeImmutable
    {
        return $this->toDate;
    }

    public function setToDate(DateTimeImmutable $toDate): void
    {
        $this->toDate = $toDate;
    }

    public function addEntry(Entry $entry): void
    {
        $this->entries[] = $entry;
    }

    /**
     * @return Entry[]
     */
    public function getEntries(): array
    {
        return $this->entries;
    }

    public function getAdditionalInformation(): ?string
    {
        return $this->additionalInformation;
    }

    public function setAdditionalInformation(string $additionalInformation): void
    {
        $this->additionalInformation = $additionalInformation;
    }
}
