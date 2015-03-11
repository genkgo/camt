<?php
namespace Genkgo\Camt\Unit\Camt053;

use Genkgo\Camt\AbstractTestCase;
use Genkgo\Camt\Camt053\GroupHeader;
use Genkgo\Camt\Camt053\Message;
use Genkgo\Camt\Camt053\Statement;
use Genkgo\Camt\Exception\InvalidMessageException;

class MessageTest extends AbstractTestCase {

    protected function getDefaultDocument () {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->load(__DIR__.'/Stubs/camt053.minimal.xml');
        return $dom;
    }

    public function testWrongDocument () {
        $this->setExpectedException(InvalidMessageException::class);

        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->load(__DIR__.'/Stubs/camt053.wrong.xml');
        new Message($dom);
    }

    public function testGroupHeader () {
        $message = new Message($this->getDefaultDocument());
        $groupHeader = $message->getGroupHeader();

        $this->assertInstanceOf(GroupHeader::class, $groupHeader);
        $this->assertEquals('CAMT053RIB000000000001', $groupHeader->getMessageId());
        $this->assertEquals(new \DateTimeImmutable('2015-03-10T18:43:50+00:00'), $groupHeader->getCreatedOn());
    }

    public function testStatements () {
        $message = new Message($this->getDefaultDocument());
        $statements = $message->getStatements();

        $this->assertCount(1, $statements);
        foreach ($statements as $statement) {
            $this->assertInstanceOf(Statement::class, $statement);
            $this->assertEquals('NL26VAYB8060476890', (string) $statement->getAccount()->getIban());
            $this->assertEquals(new \DateTimeImmutable('2015-03-10T18:43:50+00:00'), $statement->getCreatedOn());
        }
    }

    public function testBalance () {
        $message = new Message($this->getDefaultDocument());
        $statements = $message->getStatements();

        $this->assertCount(1, $statements);
        foreach ($statements as $statement) {
            $balances = $statement->getBalances();
            $this->assertCount(2, $balances);

            foreach ($balances as $item => $balance) {
                if ($item === 0) {
                    $this->assertEquals(1815, $balance->getAmount()->getAmount());
                    $this->assertEquals('EUR', $balance->getAmount()->getCurrency()->getName());
                    $this->assertEquals('opening', $balance->getType());
                }

                if ($item === 1) {
                    $this->assertEquals(2700, $balance->getAmount()->getAmount());
                    $this->assertEquals('EUR', $balance->getAmount()->getCurrency()->getName());
                    $this->assertEquals('closing', $balance->getType());
                }
            }
        }
    }

}