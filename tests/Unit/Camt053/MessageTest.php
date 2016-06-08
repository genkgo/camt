<?php

namespace Genkgo\Camt\Unit\Camt053;

use Genkgo\Camt\AbstractTestCase;
use Genkgo\Camt\Camt053\Decoder;
use Genkgo\Camt\Camt053\MessageFormat;
use Genkgo\Camt\Camt053\DTO;
use Genkgo\Camt\Exception\InvalidMessageException;

class MessageTest extends AbstractTestCase
{
    protected function getDefaultMessage()
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->load(__DIR__.'/Stubs/camt053.minimal.xml');

        return (new MessageFormat\Camt053V02)->getDecoder()->decode($dom);
    }

    protected function getV3Message()
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->load(__DIR__.'/Stubs/camt053.v3.xml');

        return (new MessageFormat\Camt053V03)->getDecoder()->decode($dom);
    }

    public function testWrongDocument()
    {
        $this->setExpectedException(InvalidMessageException::class);

        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->load(__DIR__.'/Stubs/camt053.wrong.xml');

        return (new MessageFormat\Camt053V02)->getDecoder()->decode($dom);
    }

    public function testFiveDecimalsStatement()
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->load(__DIR__.'/Stubs/camt053.five.decimals.xml');
        (new MessageFormat\Camt053V02)->getDecoder()->decode($dom);
    }

    public function testV3Document()
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->load(__DIR__.'/Stubs/camt053.v3.xml');
        (new MessageFormat\Camt053V03)->getDecoder()->decode($dom);
    }

    public function testGroupHeader()
    {
        $message = $this->getDefaultMessage();
        $groupHeader = $message->getGroupHeader();

        $this->assertInstanceOf(DTO\GroupHeader::class, $groupHeader);
        $this->assertEquals('CAMT053RIB000000000001', $groupHeader->getMessageId());
        $this->assertEquals(new \DateTimeImmutable('2015-03-10T18:43:50+00:00'), $groupHeader->getCreatedOn());
    }

    public function testStatements()
    {
        $message = $this->getDefaultMessage();
        $statements = $message->getStatements();

        $this->assertCount(1, $statements);
        foreach ($statements as $statement) {
            $this->assertInstanceOf(DTO\Statement::class, $statement);
            $this->assertEquals('253EURNL26VAYB8060476890', $statement->getId());
            $this->assertEquals('NL26VAYB8060476890', (string) $statement->getAccount()->getIban());
            $this->assertEquals(new \DateTimeImmutable('2015-03-10T18:43:50+00:00'), $statement->getCreatedOn());
        }
    }

    public function testBalance()
    {
        $message = $this->getDefaultMessage();
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

    public function testEntries()
    {
        $message = $this->getDefaultMessage();
        $statements = $message->getStatements();

        $this->assertCount(1, $statements);
        foreach ($statements as $statement) {
            $entries = $statement->getEntries();
            $this->assertCount(1, $entries);

            foreach ($entries as $entry) {
                $this->assertEquals(885, $entry->getAmount()->getAmount());
                $this->assertEquals('EUR', $entry->getAmount()->getCurrency()->getName());
                $this->assertEquals('2014-12-31', $entry->getBookingDate()->format('Y-m-d'));
                $this->assertEquals('2015-01-02', $entry->getValueDate()->format('Y-m-d'));

                $details = $entry->getTransactionDetails();
                $this->assertCount(1, $details);
                foreach ($details as $detail) {
                    $parties = $detail->getRelatedParties();
                    $this->assertCount(1, $parties);
                    foreach ($parties as $party) {
                        $this->assertEquals('Company Name', $party->getRelatedPartyType()->getName());
                        $this->assertEquals('NL', $party->getRelatedPartyType()->getAddress()->getCountry());
                        $this->assertEquals([], $party->getRelatedPartyType()->getAddress()->getAddressLines());
                        $this->assertEquals('NL56AGDH9619008421', (string) $party->getAccount()->getIban());
                    }

                    $references = $detail->getReferences();
                    $this->assertCount(1, $references);
                    foreach ($references as $reference) {
                        $this->assertEquals('000000001', $reference->getEndToEndId());
                        $this->assertNull($reference->getMandateId());
                    }

                    $remittanceInformation = $detail->getRemittanceInformation();
                    $this->assertEquals('Transaction Description', $remittanceInformation->getMessage());
                }
            }
        }
    }

    public function testStructuredMessage()
    {
        $message = $this->getV3Message();
        $statements = $message->getStatements();

        $this->assertCount(1, $statements);
        foreach ($statements as $statement) {
            $entries = $statement->getEntries();
            $this->assertCount(1, $entries);

            foreach ($entries as $entry) {
                $details = $entry->getTransactionDetails();
                $this->assertCount(1, $details);
                foreach ($details as $detail) {
                    $remittanceInformation = $detail->getRemittanceInformation();
                    $this->assertEquals('4654654654654654', $remittanceInformation->getMessage());
                }
            }
        }
    }
}
