<?php
namespace Genkgo\Camt\Camt053\Iterator;

use AppendIterator;
use ArrayIterator;
use Genkgo\Camt\Camt053\DTO;

/**
 * Class SimpleEntryIterator
 * @package Genkgo\Camt\Camt053\Iterator
 */
class EntryIterator extends \IteratorIterator
{
    /**
     * @param Message $message
     */
    public function __construct(DTO\Message $message)
    {
        $appendIterator = new AppendIterator();
        $statements = $message->getStatements();
        foreach ($statements as $statement) {
            $appendIterator->append(new ArrayIterator($statement->getEntries()));
        }

        parent::__construct($appendIterator);
    }
}
