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
