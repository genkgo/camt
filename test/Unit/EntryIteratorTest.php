<?php

declare(strict_types=1);

namespace Genkgo\TestCamt\Unit;

use DOMDocument;
use Genkgo\Camt\Camt053\MessageFormat;
use Genkgo\Camt\DTO;
use Genkgo\Camt\DTO\Message;
use Genkgo\TestCamt\AbstractTestCase;

class EntryIteratorTest extends AbstractTestCase
{
    protected function getDefaultMessage(): Message
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->load(__DIR__ . '/Camt053/Stubs/camt053.v2.multi.statement.xml');

        return (new MessageFormat\V02())->getDecoder()->decode($dom);
    }

    public function testMultipleStatements(): void
    {
        $message = $this->getDefaultMessage();
        $entries = $message->getEntries();

        $item = 0;
        foreach ($entries as $entry) {
            // @var DTO\Entry $entry
            if ($item === 0) {
                self::assertEquals(885, $entry->getAmount()->getAmount());
                self::assertEquals(
                    'Transaction Description 1',
                    $entry->getTransactionDetail()->getRemittanceInformation()->getMessage()
                );
                self::assertEquals(
                    'Company Name 1',
                    $entry->getTransactionDetail()->getRelatedParty()->getRelatedPartyType()->getName()
                );
                self::assertEquals(
                    'NL',
                    $entry->getTransactionDetail()->getRelatedParty()->getRelatedPartyType()->getAddress()->getCountry()
                );
                self::assertEquals(
                    '000000001',
                    $entry->getTransactionDetail()->getReference()->getEndToEndId()
                );
            }

            if ($item === 1) {
                self::assertEquals(-700, $entry->getAmount()->getAmount());
                self::assertEquals(
                    'Transaction Description 2',
                    $entry->getTransactionDetail()->getRemittanceInformation()->getMessage()
                );
                self::assertEquals(
                    'Company Name 2',
                    $entry->getTransactionDetail()->getRelatedParty()->getRelatedPartyType()->getName()
                );
                self::assertEquals(
                    'FR',
                    $entry->getTransactionDetail()->getRelatedParty()->getRelatedPartyType()->getAddress()->getCountry()
                );
                self::assertEquals(
                    '000000002',
                    $entry->getTransactionDetail()->getReference()->getEndToEndId()
                );
            }

            ++$item;
        }
    }
}
