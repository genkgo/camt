<?php

namespace Genkgo\Camt\Unit\Camt053;

use Genkgo\Camt\AbstractTestCase;
use Genkgo\Camt\Decoder;
use Genkgo\Camt\Camt053\MessageFormat;
use Genkgo\Camt\Camt053\DTO as Camt053DTO;
use Genkgo\Camt\DTO;
use Genkgo\Camt\Exception\InvalidMessageException;

class EndToEndTest extends AbstractTestCase
{
    protected function getV2Message()
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->load(__DIR__.'/Stubs/camt053.v2.minimal.xml');

        return (new MessageFormat\V02)->getDecoder()->decode($dom);
    }

    protected function getV3Message()
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->load(__DIR__.'/Stubs/camt053.v3.xml');

        return (new MessageFormat\V03)->getDecoder()->decode($dom);
    }

    protected function getV4Message()
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->load(__DIR__.'/Stubs/camt053.v4.xml');

        return (new MessageFormat\V04)->getDecoder()->decode($dom);
    }

    public function testWrongDocument()
    {
        $this->setExpectedException(InvalidMessageException::class);

        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->load(__DIR__.'/Stubs/camt053.v2.wrong.xml');

        return (new MessageFormat\V02)->getDecoder()->decode($dom);
    }

    public function testFiveDecimalsStatement()
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->load(__DIR__.'/Stubs/camt053.v2.five.decimals.xml');
        (new MessageFormat\V02)->getDecoder()->decode($dom);
    }

    public function testV3Document()
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->load(__DIR__.'/Stubs/camt053.v3.xml');
        (new MessageFormat\V03)->getDecoder()->decode($dom);
    }

    public function testV4Document()
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->load(__DIR__.'/Stubs/camt053.v4.xml');
        (new MessageFormat\V04)->getDecoder()->decode($dom);
    }

    public function testGroupHeader()
    {
        $messages = [
            $this->getV2Message(),
            $this->getV3Message(),
            $this->getV4Message(),
        ];

        foreach ($messages as $message) {
            $groupHeader = $message->getGroupHeader();

            $this->assertInstanceOf(DTO\GroupHeader::class, $groupHeader);
            $this->assertEquals('CAMT053RIB000000000001', $groupHeader->getMessageId());
            $this->assertEquals(new \DateTimeImmutable('2015-03-10T18:43:50+00:00'), $groupHeader->getCreatedOn());
        }
    }

    public function testStatements()
    {
        $messages = [
            $this->getV2Message(),
            $this->getV3Message(),
            $this->getV4Message(),
        ];

        foreach ($messages as $message) {
            $statements = $message->getRecords();

            $this->assertCount(1, $statements);
            foreach ($statements as $statement) {
                $this->assertInstanceOf(Camt053DTO\Statement::class, $statement);
                $this->assertEquals('253EURNL26VAYB8060476890', $statement->getId());
                $this->assertEquals('NL26VAYB8060476890', $statement->getAccount()->getIdentification());
                $this->assertEquals(new \DateTimeImmutable('2015-03-10T18:43:50+00:00'), $statement->getCreatedOn());

                $this->assertEquals('12312', $statement->getElectronicSequenceNumber());
                $this->assertEquals('CODU', $statement->getCopyDuplicateIndicator());
            }
        }

        $statementV4 = $messages[2]->getRecords()[0];
        $this->assertInstanceOf(DTO\Pagination::class, $statementV4->getPagination());
        $this->assertEquals('2', $statementV4->getPagination()->getPageNumber());
        $this->assertEquals(true, $statementV4->getPagination()->isLastPage());
    }

    public function testBalance()
    {
        $messages = [
            $this->getV2Message(),
            $this->getV3Message(),
            $this->getV4Message(),
        ];

        foreach ($messages as $message) {
            $statements = $message->getRecords();

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
                        $this->assertEquals(-2700, $balance->getAmount()->getAmount());
                        $this->assertEquals('SEK', $balance->getAmount()->getCurrency()->getName());
                        $this->assertEquals('closing', $balance->getType());
                    }
                }
            }
        }
    }

    public function testEntries()
    {
        $messages = [
            $this->getV2Message(),
            $this->getV3Message(),
            $this->getV4Message(),
        ];

        foreach ($messages as $message) {
            $statements = $message->getRecords();

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
                            $this->assertEquals('NL56AGDH9619008421', (string) $party->getAccount()->getIdentification());
                        }

                        $references = $detail->getReferences();
                        $this->assertCount(1, $references);
                        foreach ($references as $reference) {
                            $this->assertEquals('LegalSequenceNumber', $reference->getProprietaries()[0]->getType());
                            $this->assertEquals('100', $reference->getProprietaries()[0]->getReference());
                            $this->assertNull($reference->getMandateId());
                        }

                        $remittanceInformation = $detail->getRemittanceInformation();
                        $this->assertEquals('4654654654654654', $remittanceInformation->getCreditorReferenceInformation()->getRef());
                    }
                }
            }
        }
    }

    public function testStructuredMessage()
    {
        $messages = [
            $this->getV2Message(),
            $this->getV3Message(),
            $this->getV4Message(),
        ];

        foreach ($messages as $message) {
            $statements = $message->getRecords();

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
}
