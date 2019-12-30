<?php

namespace Genkgo\TestCamt\Unit\Camt054;

use Genkgo\TestCamt\AbstractTestCase;
use Genkgo\Camt\Camt054\MessageFormat;
use Genkgo\Camt\Camt054\DTO as Camt054DTO;
use Genkgo\Camt\DTO;
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
            $this->assertEquals('Group header additional information', $groupHeader->getAdditionalInformation());
            $this->assertInstanceOf(DTO\Pagination::class, $groupHeader->getPagination());
            $this->assertEquals('1', $groupHeader->getPagination()->getPageNumber());
            $this->assertEquals(true, $groupHeader->getPagination()->isLastPage());
            $msgRecipient = $groupHeader->getMessageRecipient();
            $this->assertInstanceOf(DTO\Recipient::class, $msgRecipient);
            $this->assertEquals('COMPANY BVBA', $msgRecipient->getName());
            $this->assertEquals('NL', $msgRecipient->getCountryOfResidence());
            $this->assertInstanceOf(DTO\Address::class, $msgRecipient->getAddress());
            $this->assertEquals('12 Oxford Street', $msgRecipient->getAddress()->getStreetName());
            $this->assertEquals('UK', $msgRecipient->getAddress()->getCountry());
            $this->assertInstanceOf(DTO\Identification::class, $msgRecipient->getIdentification());
            $this->assertEquals('DABAIE2D', $msgRecipient->getIdentification()->getBic());
            $this->assertEquals('Some other Id', $msgRecipient->getIdentification()->getOtherId());
            $this->assertEquals('Some other Issuer', $msgRecipient->getIdentification()->getOtherIssuer());
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
                    $this->assertEquals('SEK', $entry->getAmount()->getCurrency()->getCode());
                    $this->assertEquals('2007-10-18', $entry->getBookingDate()->format('Y-m-d'));
                    $this->assertEquals('2007-10-18', $entry->getValueDate()->format('Y-m-d'));
                    $this->assertEquals('PMNT', $entry->getBankTransactionCode()->getDomain()->getCode());
                    $this->assertEquals('ICDT', $entry->getBankTransactionCode()->getDomain()->getFamily()->getCode());
                    $this->assertEquals('DMCT', $entry->getBankTransactionCode()->getDomain()->getFamily()->getSubFamilyCode());
                }
            }
        }
    }

    public function testTransactionDetails()
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
                    $transactionDetails = $entry->getTransactionDetails();

                    $this->assertCount(3, $transactionDetails);
                    foreach ($transactionDetails as $index=>$transactionDetail) {
                        switch ($index) {
                            case 0:
                                // Legacy : The first message comes from unstructured block
                                $this->assertEquals(
                                    'Unstructured Remittance Information V1',
                                    $transactionDetail
                                            ->getRemittanceInformation()
                                            ->getMessage()
                                );

                                // Only one structured data block
                                $this->assertEquals(
                                    'Unstructured Remittance Information V1',
                                    $transactionDetail
                                            ->getRemittanceInformation()
                                            ->getUnstructuredBlock()
                                            ->getMessage()
                                );

                                // Check structured and unstructured blocks
                                $this->assertEquals(
                                    'ISR ref number V1',
                                    $transactionDetail
                                            ->getRemittanceInformation()
                                            ->getStructuredBlock()
                                            ->getCreditorReferenceInformation()
                                            ->getRef()
                                );

                                $this->assertEquals(
                                    'ISR Reference',
                                    $transactionDetail
                                            ->getRemittanceInformation()
                                            ->getStructuredBlock()
                                            ->getCreditorReferenceInformation()
                                            ->getProprietary()
                                );

                                $this->assertEquals(
                                    null,
                                    $transactionDetail
                                            ->getRemittanceInformation()
                                            ->getStructuredBlock()
                                            ->getCreditorReferenceInformation()
                                            ->getCode()
                                );

                                $this->assertEquals(
                                    'Additional Remittance Information V1',
                                    $transactionDetail
                                            ->getRemittanceInformation()
                                            ->getStructuredBlock()
                                            ->getAdditionalRemittanceInformation()
                                );
                                break;
                            case 1:

                                // Legacy : ref number from the structured information
                                // because the unstructured block is not present
                                $this->assertEquals(
                                    'ISR ref number V2',
                                    $transactionDetail
                                            ->getRemittanceInformation()
                                            ->getMessage()
                                );

                                // No unstructured block
                                $this->assertEquals(
                                    0,
                                    count(
                                        $transactionDetail
                                                ->getRemittanceInformation()
                                                ->getUnstructuredBlocks()
                                    )
                                );

                                // Check structured and unstructured blocks
                                $this->assertEquals(
                                    'ISR ref number V2',
                                    $transactionDetail
                                            ->getRemittanceInformation()
                                            ->getStructuredBlock()
                                            ->getCreditorReferenceInformation()
                                            ->getRef()
                                );

                                $this->assertEquals(
                                    'ISR Reference',
                                    $transactionDetail
                                            ->getRemittanceInformation()
                                            ->getStructuredBlock()
                                            ->getCreditorReferenceInformation()
                                            ->getProprietary()
                                );

                                $this->assertEquals(
                                    null,
                                    $transactionDetail
                                            ->getRemittanceInformation()
                                            ->getStructuredBlock()
                                            ->getCreditorReferenceInformation()
                                            ->getCode()
                                );

                                $this->assertEquals(
                                    'Additional Remittance Information V2',
                                    $transactionDetail
                                            ->getRemittanceInformation()
                                            ->getStructuredBlock()
                                            ->getAdditionalRemittanceInformation()
                                );

                                break;
                            case 2:
                                // Legacy : ref number from the first unstructured block
                                $this->assertEquals(
                                    'Unstructured Remittance Information V3 block 1',
                                    $transactionDetail
                                            ->getRemittanceInformation()
                                            ->getMessage()
                                );

                                // First unstructured block
                                $this->assertEquals(
                                    'Unstructured Remittance Information V3 block 1',
                                    $transactionDetail
                                            ->getRemittanceInformation()
                                            ->getUnstructuredBlocks()[0]
                                            ->getMessage()
                                );

                                // Second unstructured block
                                $this->assertEquals(
                                    'Unstructured Remittance Information V3 block 2',
                                    $transactionDetail
                                            ->getRemittanceInformation()
                                            ->getUnstructuredBlocks()[1]
                                            ->getMessage()
                                );

                                // Ref number from the first structured block
                                $this->assertEquals(
                                    'Ref number V3 block 1',
                                    $transactionDetail
                                            ->getRemittanceInformation()
                                            ->getStructuredBlocks()[0]
                                            ->getCreditorReferenceInformation()
                                            ->getRef()
                                );

                                // Ref number from the second structured block
                                $this->assertEquals(
                                    'Ref number V3 block 2',
                                    $transactionDetail
                                            ->getRemittanceInformation()
                                            ->getStructuredBlocks()[1]
                                            ->getCreditorReferenceInformation()
                                            ->getRef()
                                );

                                // Code from the first structured block
                                $this->assertEquals(
                                    'SCOR',
                                    $transactionDetail
                                            ->getRemittanceInformation()
                                            ->getStructuredBlocks()[0]
                                            ->getCreditorReferenceInformation()
                                            ->getCode()
                                );

                                // Code from the second structured block
                                $this->assertEquals(
                                    'SCOR',
                                    $transactionDetail
                                            ->getRemittanceInformation()
                                            ->getStructuredBlocks()[1]
                                            ->getCreditorReferenceInformation()
                                            ->getCode()
                                );

                                // Additional remittance information from the first structured block
                                $this->assertEquals(
                                    'Additional Remittance Information V3 block 1',
                                    $transactionDetail
                                            ->getRemittanceInformation()
                                            ->getStructuredBlocks()[0]
                                            ->getAdditionalRemittanceInformation()
                                );

                                // Additional remittance information from the second structured block
                                $this->assertEquals(
                                    'Additional Remittance Information V3 block 2',
                                    $transactionDetail
                                            ->getRemittanceInformation()
                                            ->getStructuredBlocks()[1]
                                            ->getAdditionalRemittanceInformation()
                                );
                                break;
                            default:
                                break;
                        }
                    }
                }
            }
        }
    }
}
