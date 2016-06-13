<?php
namespace Genkgo\Camt\Iterator;

use AppendIterator;
use ArrayIterator;
use Genkgo\Camt\DTO;

/**
 * Class SimpleEntryIterator
 * @package Genkgo\Camt\Iterator
 */
class EntryIterator extends \IteratorIterator
{
    /**
     * @param Message $message
     */
    public function __construct(DTO\Message $message)
    {
        $appendIterator = new AppendIterator();
        $records = $message->getRecords();
        foreach ($records as $record) {
            $appendIterator->append(new ArrayIterator($record->getEntries()));
        }

        parent::__construct($appendIterator);
    }
}
