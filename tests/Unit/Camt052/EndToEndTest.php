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
    public function testGroupHeader()
    {
        $message = $this->getV1Message();

        $groupHeader = $message->getGroupHeader();

        $this->assertInstanceOf(DTO\GroupHeader::class, $groupHeader);
        $this->assertEquals('AAAASESS-FP-ACCR001', $groupHeader->getMessageId());
        $this->assertEquals(new \DateTimeImmutable('2007-10-18T12:30:00+01:00'), $groupHeader->getCreatedOn());
    }

    public function testReports()
    {
        $message = $this->getV1Message();

        $reports = $message->getRecords();

        $this->assertCount(1, $reports);
        foreach ($reports as $report) {
            $this->assertInstanceOf(Camt052DTO\Report::class, $report);
            $this->assertEquals('AAAASESS-FP-ACCR001', $report->getId());
            $this->assertEquals('50000000054910000003', $report->getAccount()->getIdentification());
            $this->assertEquals(new \DateTimeImmutable('2007-10-18T12:30:00+01:00'), $report->getCreatedOn());
        }
    }

    public function testEntries()
    {
        $message = $this->getV1Message();

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
}
