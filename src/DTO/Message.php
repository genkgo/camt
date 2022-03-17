<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

use Genkgo\Camt\Iterator\EntryIterator;

class Message
{
    private GroupHeader $groupHeader;

    /**
     * @var Record[]
     */
    private array $records = [];

    public function getGroupHeader(): GroupHeader
    {
        return $this->groupHeader;
    }

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
