<?php

namespace Genkgo\Camt\Camt053\DTO;

/**
 * Class Statement
 * @package Genkgo\Camt\Camt053
 */
class Statement
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var \DateTimeImmutable
     */
    private $createdOn;
    /**
     * @var Account
     */
    private $account;
    /**
     * @var array
     */
    private $balances = [];
    /**
     * @var array
     */
    private $entries = [];

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
     * @param Balance $balance
     */
    public function addBalance(Balance $balance)
    {
        $this->balances[] = $balance;
    }

    /**
     * @return Balance[]
     */
    public function getBalances()
    {
        return $this->balances;
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
