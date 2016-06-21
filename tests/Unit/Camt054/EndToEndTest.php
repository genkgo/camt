<?php

namespace Genkgo\Camt\Unit\Camt054;

use Genkgo\Camt\AbstractTestCase;
use Genkgo\Camt\Decoder;
use Genkgo\Camt\Camt054\MessageFormat;
use Genkgo\Camt\Camt054\DTO as Camt054DTO;
use Genkgo\Camt\DTO;
use Genkgo\Camt\Exception\InvalidMessageException;
use DateTimeImmutable;

class EndToEndTest extends AbstractTestCase
{
    protected function getV2Message()
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->load(__DIR__.'/Stubs/camt054.v2.xml');

        return (new MessageFormat\V02)->getDecoder()->decode($dom);
    }

    protected function getV4Message()
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->load(__DIR__.'/Stubs/camt054.v4.xml');

        return (new MessageFormat\V04)->getDecoder()->decode($dom);
    }

    public function testGroupHeader()
    {
        $messages = [
            $this->getV2Message(),
            $this->getV4Message(),
        ];

        foreach ($messages as $message) {
            $groupHeader = $message->getGroupHeader();

            $this->assertInstanceOf(DTO\GroupHeader::class, $groupHeader);
            $this->assertEquals('AAAASESS-FP-ACCR001', $groupHeader->getMessageId());
            $this->assertEquals(new DateTimeImmutable('2007-10-18T12:30:00+01:00'), $groupHeader->getCreatedOn());
        }

        $groupHeaderV4 = $messages[1]->getGroupHeader();
        $this->assertInstanceOf(Camt054DTO\V04\GroupHeader::class, $groupHeaderV4);
        $this->assertInstanceOf(Camt054DTO\V04\OriginalBusinessQuery::class, $groupHeaderV4->getOriginalBusinessQuery());
        $this->assertEquals('SomeMessageId', $groupHeaderV4->getOriginalBusinessQuery()->getMessageId());
        $this->assertEquals(
            'SomeMessageNameId',
            $groupHeaderV4->getOriginalBusinessQuery()->getMessageNameId()
        );
        $this->assertEquals(
            new DateTimeImmutable('2010-10-18T12:30:00+01:00'),
            $groupHeaderV4->getOriginalBusinessQuery()->getCreatedOn()
        );
    }

    public function testNotifications()
    {
        $messages = [
            $this->getV2Message(),
            $this->getV4Message(),
        ];

        foreach ($messages as $message) {
            $notifications = $message->getRecords();

            $this->assertCount(1, $notifications);
            foreach ($notifications as $notification) {
                $this->assertInstanceOf(Camt054DTO\Notification::class, $notification);
                $this->assertEquals('AAAASESS-FP-ACCR001', $notification->getId());
                $this->assertEquals('CH2801234000123456789', $notification->getAccount()->getIdentification());
                $this->assertEquals(new DateTimeImmutable('2007-10-18T12:30:00+01:00'), $notification->getCreatedOn());
                $this->assertEquals('12312', $notification->getElectronicSequenceNumber());
                $this->assertEquals('12312', $notification->getLegalSequenceNumber());
                $this->assertEquals('CODU', $notification->getCopyDuplicateIndicator());
                $this->assertEquals(new DateTimeImmutable('2007-10-18T08:00:00+01:00'), $notification->getFromDate());
                $this->assertEquals(new DateTimeImmutable('2007-10-18T12:30:00+01:00'), $notification->getToDate());
                $this->assertEquals('Additional Information', $notification->getAdditionalInformation());
            }
        }

        $notificationV4 = $messages[1]->getRecords()[0];
        $this->assertInstanceOf(DTO\Pagination::class, $notificationV4->getPagination());
        $this->assertEquals('2', $notificationV4->getPagination()->getPageNumber());
        $this->assertEquals(true, $notificationV4->getPagination()->isLastPage());
    }

    public function testEntries()
    {
        $messages = [
            $this->getV2Message(),
            $this->getV4Message(),
        ];

        foreach ($messages as $message) {
            $notifications = $message->getRecords();

            $this->assertCount(1, $notifications);
            foreach ($notifications as $notification) {
                $entries = $notification->getEntries();
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
