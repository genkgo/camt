<?php

namespace Genkgo\Camt\Unit\Camt052;

use Genkgo\Camt\AbstractTestCase;
use Genkgo\Camt\Decoder;
use Genkgo\Camt\Camt052\MessageFormat;
use Genkgo\Camt\Camt052\DTO as Camt052DTO;
use Genkgo\Camt\DTO;
use Genkgo\Camt\Exception\InvalidMessageException;

class EndToEndTest extends AbstractTestCase
{
    protected function getV1Message()
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->load(__DIR__.'/Stubs/camt052.v1.xml');

        return (new MessageFormat\V01)->getDecoder()->decode($dom);
    }

    protected function getV2Message()
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->load(__DIR__.'/Stubs/camt052.v2.xml');

        return (new MessageFormat\V02)->getDecoder()->decode($dom);
    }

    protected function getV4Message()
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->load(__DIR__.'/Stubs/camt052.v4.xml');

        return (new MessageFormat\V04)->getDecoder()->decode($dom);
    }

    public function testGroupHeader()
    {
        $messages = [
            $this->getV1Message(),
            $this->getV2Message(),
            $this->getV4Message(),
        ];

        foreach ($messages as $message) {
            $groupHeader = $message->getGroupHeader();

            $this->assertInstanceOf(DTO\GroupHeader::class, $groupHeader);
            $this->assertEquals('AAAASESS-FP-ACCR001', $groupHeader->getMessageId());
            $this->assertEquals(new \DateTimeImmutable('2007-10-18T12:30:00+01:00'), $groupHeader->getCreatedOn());
        }
    }

    public function testReports()
    {
        $messages = [
            $this->getV1Message(),
            $this->getV2Message(),
            $this->getV4Message(),
        ];

        foreach ($messages as $message) {
            $reports = $message->getRecords();

            $this->assertCount(1, $reports);
            foreach ($reports as $report) {
                $this->assertInstanceOf(Camt052DTO\Report::class, $report);
                $this->assertEquals('AAAASESS-FP-ACCR001', $report->getId());
                $this->assertEquals('CH2801234000123456789', $report->getAccount()->getIdentification());
                $this->assertEquals(new \DateTimeImmutable('2007-10-18T12:30:00+01:00'), $report->getCreatedOn());
                $this->assertEquals('12312', $report->getElectronicSequenceNumber());
                $this->assertEquals('CODU', $report->getCopyDuplicateIndicator());
            }
        }
    }

    public function testEntries()
    {
        $messages = [
            $this->getV1Message(),
            $this->getV2Message(),
            $this->getV4Message(),
        ];

        foreach ($messages as $message) {
            $reports = $message->getRecords();

            $this->assertCount(1, $reports);
            foreach ($reports as $report) {
                $entries = $report->getEntries();
                $this->assertCount(1, $entries);

                foreach ($entries as $entry) {
                    $this->assertEquals(-20000000, $entry->getAmount()->getAmount());
                    $this->assertEquals('SEK', $entry->getAmount()->getCurrency()->getName());
                    $this->assertEquals('2007-10-18', $entry->getBookingDate()->format('Y-m-d'));
                    $this->assertEquals('2007-10-18', $entry->getValueDate()->format('Y-m-d'));
                }
            }
        }

        $reportV4 = $messages[2]->getRecords()[0];
        $this->assertInstanceOf(DTO\Pagination::class, $reportV4->getPagination());
        $this->assertEquals('2', $reportV4->getPagination()->getPageNumber());
        $this->assertEquals(true, $reportV4->getPagination()->isLastPage());
    }
}
