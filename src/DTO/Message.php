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
    public function getGroupHeader()
    {
        return $this->groupHeader;
    }

    /**
     * @param GroupHeader $groupHeader
     */
    public function setGroupHeader($groupHeader)
    {
        $this->groupHeader = $groupHeader;
    }

    /**
     * @return Record[]
     */
    public function getRecords()
    {
        return $this->records;
    }

    /**
     * @param Record[] $records
     */
    public function setRecords(array $records)
    {
        $this->records = $records;
    }

    /**
     * @return Entry[]|EntryIterator
     */
    public function getEntries()
    {
        return new EntryIterator($this);
    }
}
