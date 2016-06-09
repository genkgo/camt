<?php

namespace Genkgo\Camt\Camt053\DTO;

use Genkgo\Camt\Camt053\Iterator\EntryIterator;

/**
 * Class Message
 * @package Genkgo\Camt\Camt053
 */
class Message
{
    /**
     * @var
     */
    private $groupHeader;
    /**
     * @var
     */
    private $statements;

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
     * @return Statement[]
     */
    public function getStatements()
    {
        return $this->statements;
    }

    /**
     * @param Statement[] $statements
     */
    public function setStatements(array $statements)
    {
        $this->statements = $statements;
    }

    /**
     * @return EntryIterator|Entry[]
     */
    public function getEntries()
    {
        return new EntryIterator($this);
    }
}
