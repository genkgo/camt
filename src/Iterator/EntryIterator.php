<?php

declare(strict_types=1);

namespace Genkgo\Camt\Iterator;

use AppendIterator;
use ArrayIterator;
use Genkgo\Camt\DTO\Entry;
use Genkgo\Camt\DTO\Message;
use IteratorIterator;

/**
 * @extends IteratorIterator<int, Entry, AppendIterator>
 */
class EntryIterator extends IteratorIterator
{
    public function __construct(Message $message)
    {
        $appendIterator = new AppendIterator();
        $records = $message->getRecords();
        foreach ($records as $record) {
            $appendIterator->append(new ArrayIterator($record->getEntries()));
        }

        parent::__construct($appendIterator);
    }
}
