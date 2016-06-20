<?php

namespace Genkgo\Camt\DTO;

use DateTimeImmutable;

/**
 * Class Record
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
     * @var Pagination|null
     */
    protected $pagination;

    /**
     * @var string|null
     */
    protected $electronicSequenceNumber;

    /**
     * @var string|null
     */
    protected $legalSequenceNumber;

    /**
     * @var string|null
     */
    protected $copyDuplicateIndicator;

    /**
     * @var DateTimeImmutable|null
     */
    protected $fromDate;

    /**
     * @var DateTimeImmutable|null
     */
    protected $toDate;

    /**
     * @var array
     */
    protected $entries = [];

    /**
     * @var string|null
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
     * @return Pagination
     */
    public function getPagination()
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
     * @return string
     */
    public function getElectronicSequenceNumber()
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
     * @return string
     */
    public function getLegalSequenceNumber()
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
     * @param string $copyDuplicateIndicator
     */
    public function getCopyDuplicateIndicator()
    {
        return $this->copyDuplicateIndicator;
    }
    
    /**
     * @return string
     */
    public function setCopyDuplicateIndicator($copyDuplicateIndicator)
    {
        $this->copyDuplicateIndicator = $copyDuplicateIndicator;
    }

    /**
     * @return DateTimeImmutable|null
     */
    public function getFromDate()
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
     * @return DateTimeImmutable|null
     */
    public function getToDate()
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
     * @return string|null
     */
    public function getAdditionalInformation()
    {
        return $this->additionalInformation;
    }

    /**
     * @param string
     */
    public function setAdditionalInformation($additionalInformation)
    {
        $this->additionalInformation = $additionalInformation;
    }
}
