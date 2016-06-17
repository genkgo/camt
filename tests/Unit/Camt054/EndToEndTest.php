<?php

namespace Genkgo\Camt\Unit\Camt054;

use Genkgo\Camt\AbstractTestCase;
use Genkgo\Camt\Decoder;
use Genkgo\Camt\Camt054\MessageFormat;
use Genkgo\Camt\Camt054\DTO as Camt054DTO;
use Genkgo\Camt\DTO;
use Genkgo\Camt\Exception\InvalidMessageException;

class EndToEndTest extends AbstractTestCase
{
    protected function getV2Message()
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->load(__DIR__.'/Stubs/camt054.v2.xml');

        return (new MessageFormat\V02)->getDecoder()->decode($dom);
    }

    public function testGroupHeader()
    {
        $messages = [
            $this->getV2Message(),
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
            $this->getV2Message(),
        ];

        foreach ($messages as $message) {
            $reports = $message->getRecords();

            $this->assertCount(1, $reports);
            foreach ($reports as $report) {
                $this->assertInstanceOf(Camt054DTO\Notification::class, $report);
                $this->assertEquals('AAAASESS-FP-ACCR001', $report->getId());
                $this->assertEquals('CH2801234000123456789', $report->getAccount()->getIdentification());
                $this->assertEquals(new \DateTimeImmutable('2007-10-18T12:30:00+01:00'), $report->getCreatedOn());
            }
        }
    }

    public function testEntries()
    {
        $messages = [
            $this->getV2Message(),
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
    }
}
