<?php

namespace Genkgo\Camt\DTO;

use DateTimeImmutable;

/**
 * Class Record
 *
 * @package Genkgo\Camt\DTO
 */
abstract class Record
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var DateTimeImmutable
     */
    protected $createdOn;

    /**
     * @var Account
     */
    protected $account;

    /**
     * @var null|Pagination
     */
    protected $pagination;

    /**
     * @var null|string
     */
    protected $electronicSequenceNumber;

    /**
     * @var null|string
     */
    protected $legalSequenceNumber;

    /**
     * @var null|string
     */
    protected $copyDuplicateIndicator;

    /**
     * @var null|DateTimeImmutable
     */
    protected $fromDate;

    /**
     * @var null|DateTimeImmutable
     */
    protected $toDate;

    /**
     * @var array
     */
    protected $entries = [];

    /**
     * @var null|string
     */
    protected $additionalInformation;

    /**
     * @param string $id
     * @param DateTimeImmutable $createdOn
     * @param Account $account
     */
    public function __construct(string $id, DateTimeImmutable $createdOn, Account $account)
    {
        $this->id = $id;
        $this->createdOn = $createdOn;
        $this->account = $account;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreatedOn(): DateTimeImmutable
    {
        return $this->createdOn;
    }

    /**
     * @return Account
     */
    public function getAccount(): Account
    {
        return $this->account;
    }

    /**
     * @return null|Pagination
     */
    public function getPagination(): ?Pagination
    {
        return $this->pagination;
    }

    /**
     * @param Pagination $pagination
     */
    public function setPagination(Pagination $pagination): void
    {
        $this->pagination = $pagination;
    }

    /**
     * @return null|string
     */
    public function getElectronicSequenceNumber(): ?string
    {
        return $this->electronicSequenceNumber;
    }

    /**
     * @param string $electronicSequenceNumber
     */
    public function setElectronicSequenceNumber(string $electronicSequenceNumber): void
    {
        $this->electronicSequenceNumber = $electronicSequenceNumber;
    }

    /**
     * @return null|string
     */
    public function getLegalSequenceNumber(): ?string
    {
        return $this->legalSequenceNumber;
    }

    /**
     * @param string $legalSequenceNumber
     */
    public function setLegalSequenceNumber(string $legalSequenceNumber): void
    {
        $this->legalSequenceNumber = $legalSequenceNumber;
    }

    /**
     * @return null|string
     */
    public function getCopyDuplicateIndicator(): ?string
    {
        return $this->copyDuplicateIndicator;
    }

    /**
     * @param string $copyDuplicateIndicator
     */
    public function setCopyDuplicateIndicator(string $copyDuplicateIndicator): void
    {
        $this->copyDuplicateIndicator = $copyDuplicateIndicator;
    }

    /**
     * @return null|DateTimeImmutable
     */
    public function getFromDate():?DateTimeImmutable
    {
        return $this->fromDate;
    }

    /**
     * @param DateTimeImmutable $fromDate
     */
    public function setFromDate(DateTimeImmutable $fromDate): void
    {
        $this->fromDate = $fromDate;
    }

    /**
     * @return null|DateTimeImmutable
     */
    public function getToDate():?DateTimeImmutable
    {
        return $this->toDate;
    }

    /**
     * @param DateTimeImmutable $toDate
     */
    public function setToDate(DateTimeImmutable $toDate): void
    {
        $this->toDate = $toDate;
    }

    /**
     * @param Entry $entry
     */
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

    /**
     * @return null|string
     */
    public function getAdditionalInformation(): ?string
    {
        return $this->additionalInformation;
    }

    /**
     * @param string $additionalInformation
     */
    public function setAdditionalInformation(string $additionalInformation): void
    {
        $this->additionalInformation = $additionalInformation;
    }
}
