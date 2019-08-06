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
    public function __construct($id, DateTimeImmutable $createdOn, Account $account)
    {
        $this->id = $id;
        $this->createdOn = $createdOn;
        $this->account = $account;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * @return Account
     */
    public function getAccount()
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
    public function setPagination(Pagination $pagination)
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
    public function setElectronicSequenceNumber($electronicSequenceNumber)
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
    public function setLegalSequenceNumber($legalSequenceNumber)
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
    public function setCopyDuplicateIndicator($copyDuplicateIndicator)
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
    public function setFromDate(DateTimeImmutable $fromDate)
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
    public function setToDate(DateTimeImmutable $toDate)
    {
        $this->toDate = $toDate;
    }

    /**
     * @param Entry $entry
     */
    public function addEntry(Entry $entry)
    {
        $this->entries[] = $entry;
    }

    /**
     * @return Entry[]
     */
    public function getEntries()
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
    public function setAdditionalInformation($additionalInformation)
    {
        $this->additionalInformation = $additionalInformation;
    }
}
