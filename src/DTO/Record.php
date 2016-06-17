<?php

namespace Genkgo\Camt\DTO;

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
     * @var \DateTimeImmutable
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
    protected $copyDuplicateIndicator;

    /**
     * @var array
     */
    protected $entries = [];

    /**
     * @param string $id
     * @param \DateTimeImmutable $createdOn
     * @param Account $account
     */
    public function __construct($id, \DateTimeImmutable $createdOn, Account $account)
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
     * @return \DateTimeImmutable
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
}
