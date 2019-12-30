<?php

namespace Genkgo\Camt\DTO;

use Genkgo\Camt\Iterator\EntryIterator;

/**
 * Class Message
 * @package Genkgo\Camt\DTO
 */
class Message
{
    /**
     * @var GroupHeader
     */
    private $groupHeader;

    /**
     * @var Record[]
     */
    private $records = [];

    /**
     * @return GroupHeader
     */
    public function getGroupHeader(): GroupHeader
    {
        return $this->groupHeader;
    }

    /**
     * @param GroupHeader $groupHeader
     */
    public function setGroupHeader(GroupHeader $groupHeader): void
    {
        $this->groupHeader = $groupHeader;
    }

    /**
     * @return Record[]
     */
    public function getRecords(): array
    {
        return $this->records;
    }

    /**
     * @param Record[] $records
     */
    public function setRecords(array $records): void
    {
        $this->records = $records;
    }

    /**
     * @return Entry[]|EntryIterator
     */
    public function getEntries(): EntryIterator
    {
        return new EntryIterator($this);
    }
}
