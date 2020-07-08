<?php

declare(strict_types=1);

namespace Genkgo\TestCamt\Unit\Camt054;

use DateTimeImmutable;
use DOMDocument;
use Genkgo\Camt\Camt054\DTO as Camt054DTO;
use Genkgo\Camt\Camt054\DTO\V04\GroupHeader;
use Genkgo\Camt\Camt054\MessageFormat;
use Genkgo\Camt\DTO;
use Genkgo\Camt\DTO\Message;
use Genkgo\Camt\DTO\OrganisationIdentification;
use Genkgo\TestCamt\AbstractTestCase;

class EndToEndTest extends AbstractTestCase
{
    protected function getV2Message(): Message
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->load(__DIR__ . '/Stubs/camt054.v2.xml');

        return (new MessageFormat\V02())->getDecoder()->decode($dom);
    }

    protected function getV4Message(): Message
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->load(__DIR__ . '/Stubs/camt054.v4.xml');

        return (new MessageFormat\V04())->getDecoder()->decode($dom);
    }

    public function testGroupHeader(): void
    {
        $messages = [
            $this->getV2Message(),
            $this->getV4Message(),
        ];

        /** @var Message $message */
        foreach ($messages as $message) {
            $groupHeader = $message->getGroupHeader();

            self::assertInstanceOf(DTO\GroupHeader::class, $groupHeader);
            self::assertEquals('AAAASESS-FP-ACCR001', $groupHeader->getMessageId());
            self::assertEquals(new DateTimeImmutable('2007-10-18T12:30:00+01:00'), $groupHeader->getCreatedOn());
            self::assertEquals('Group header additional information', $groupHeader->getAdditionalInformation());
            self::assertInstanceOf(DTO\Pagination::class, $groupHeader->getPagination());
            self::assertEquals('1', $groupHeader->getPagination()->getPageNumber());
            self::assertTrue($groupHeader->getPagination()->isLastPage());
            $msgRecipient = $groupHeader->getMessageRecipient();
            self::assertInstanceOf(DTO\Recipient::class, $msgRecipient);
            self::assertEquals('COMPANY BVBA', $msgRecipient->getName());
            self::assertEquals('NL', $msgRecipient->getCountryOfResidence());
            self::assertInstanceOf(DTO\Address::class, $msgRecipient->getAddress());
            self::assertEquals('12 Oxford Street', $msgRecipient->getAddress()->getStreetName());
            self::assertEquals('UK', $msgRecipient->getAddress()->getCountry());

            /** @var OrganisationIdentification $identification */
            $identification = $msgRecipient->getIdentification();
            self::assertInstanceOf(DTO\Identification::class, $identification);
            self::assertEquals('DABAIE2D', $identification->getBic());
            self::assertEquals('Some other Id', $identification->getOtherId());
            self::assertEquals('Some other Issuer', $identification->getOtherIssuer());
        }

        /** @var GroupHeader $groupHeaderV4 */
        $groupHeaderV4 = $messages[1]->getGroupHeader();
        self::assertInstanceOf(GroupHeader::class, $groupHeaderV4);
        self::assertInstanceOf(Camt054DTO\V04\OriginalBusinessQuery::class, $groupHeaderV4->getOriginalBusinessQuery());
        self::assertEquals('SomeMessageId', $groupHeaderV4->getOriginalBusinessQuery()->getMessageId());
        self::assertEquals(
            'SomeMessageNameId',
            $groupHeaderV4->getOriginalBusinessQuery()->getMessageNameId()
        );
        self::assertEquals(
            new DateTimeImmutable('2010-10-18T12:30:00+01:00'),
            $groupHeaderV4->getOriginalBusinessQuery()->getCreatedOn()
        );
    }

    public function testNotifications(): void
    {
        $messages = [
            $this->getV2Message(),
            $this->getV4Message(),
        ];

        foreach ($messages as $message) {
            $notifications = $message->getRecords();

            self::assertCount(1, $notifications);
            foreach ($notifications as $notification) {
                self::assertInstanceOf(Camt054DTO\Notification::class, $notification);
                self::assertEquals('AAAASESS-FP-ACCR001', $notification->getId());
                self::assertEquals('CH2801234000123456789', $notification->getAccount()->getIdentification());
                self::assertEquals(new DateTimeImmutable('2007-10-18T12:30:00+01:00'), $notification->getCreatedOn());
                self::assertEquals('12312', $notification->getElectronicSequenceNumber());
                self::assertEquals('12312', $notification->getLegalSequenceNumber());
                self::assertEquals('CODU', $notification->getCopyDuplicateIndicator());
                self::assertEquals(new DateTimeImmutable('2007-10-18T08:00:00+01:00'), $notification->getFromDate());
                self::assertEquals(new DateTimeImmutable('2007-10-18T12:30:00+01:00'), $notification->getToDate());
                self::assertEquals('Additional Information', $notification->getAdditionalInformation());
            }
        }

        $notificationV4 = $messages[1]->getRecords()[0];
        self::assertInstanceOf(DTO\Pagination::class, $notificationV4->getPagination());
        self::assertEquals('2', $notificationV4->getPagination()->getPageNumber());
        self::assertTrue($notificationV4->getPagination()->isLastPage());
    }

    public function testEntries(): void
    {
        $messages = [
            $this->getV2Message(),
            $this->getV4Message(),
        ];

        foreach ($messages as $message) {
            $notifications = $message->getRecords();

            self::assertCount(1, $notifications);
            foreach ($notifications as $notification) {
                $entries = $notification->getEntries();
                self::assertCount(1, $entries);

                foreach ($entries as $entry) {
                    self::assertEquals(-20000000, $entry->getAmount()->getAmount());
                    self::assertEquals('SEK', $entry->getAmount()->getCurrency()->getCode());
                    self::assertEquals('2007-10-18', $entry->getBookingDate()->format('Y-m-d'));
                    self::assertEquals('2007-10-18', $entry->getValueDate()->format('Y-m-d'));
                    self::assertEquals('PMNT', $entry->getBankTransactionCode()->getDomain()->getCode());
                    self::assertEquals('ICDT', $entry->getBankTransactionCode()->getDomain()->getFamily()->getCode());
                    self::assertEquals('DMCT', $entry->getBankTransactionCode()->getDomain()->getFamily()->getSubFamilyCode());
                }
            }
        }
    }

    public function testTransactionDetails(): void
    {
        $messages = [
            $this->getV2Message(),
            $this->getV4Message(),
        ];

        foreach ($messages as $message) {
            $notifications = $message->getRecords();

            self::assertCount(1, $notifications);
            foreach ($notifications as $notification) {
                $entries = $notification->getEntries();

                self::assertCount(1, $entries);
                foreach ($entries as $entry) {
                    $transactionDetails = $entry->getTransactionDetails();

                    self::assertCount(3, $transactionDetails);
                    foreach ($transactionDetails as $index => $transactionDetail) {
                        switch ($index) {
                            case 0:
                                // Legacy : The first message comes from unstructured block
                                self::assertEquals(
                                    'Unstructured Remittance Information V1',
                                    $transactionDetail
                                        ->getRemittanceInformation()
                                        ->getMessage()
                                );

                                // Only one structured data block
                                self::assertEquals(
                                    'Unstructured Remittance Information V1',
                                    $transactionDetail
                                        ->getRemittanceInformation()
                                        ->getUnstructuredBlock()
                                        ->getMessage()
                                );

                                // Check structured and unstructured blocks
                                self::assertEquals(
                                    'ISR ref number V1',
                                    $transactionDetail
                                        ->getRemittanceInformation()
                                        ->getStructuredBlock()
                                        ->getCreditorReferenceInformation()
                                        ->getRef()
                                );

                                self::assertEquals(
                                    'ISR Reference',
                                    $transactionDetail
                                        ->getRemittanceInformation()
                                        ->getStructuredBlock()
                                        ->getCreditorReferenceInformation()
                                        ->getProprietary()
                                );

                                self::assertNull(
                                    $transactionDetail
                                        ->getRemittanceInformation()
                                        ->getStructuredBlock()
                                        ->getCreditorReferenceInformation()
                                        ->getCode()
                                );

                                self::assertEquals(
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
                                self::assertEquals(
                                    'ISR ref number V2',
                                    $transactionDetail
                                        ->getRemittanceInformation()
                                        ->getMessage()
                                );

                                // No unstructured block
                                self::assertCount(
                                    0,

                                        $transactionDetail
                                            ->getRemittanceInformation()
                                            ->getUnstructuredBlocks()

                                );

                                // Check structured and unstructured blocks
                                self::assertEquals(
                                    'ISR ref number V2',
                                    $transactionDetail
                                        ->getRemittanceInformation()
                                        ->getStructuredBlock()
                                        ->getCreditorReferenceInformation()
                                        ->getRef()
                                );

                                self::assertEquals(
                                    'ISR Reference',
                                    $transactionDetail
                                        ->getRemittanceInformation()
                                        ->getStructuredBlock()
                                        ->getCreditorReferenceInformation()
                                        ->getProprietary()
                                );

                                self::assertNull(
                                    $transactionDetail
                                        ->getRemittanceInformation()
                                        ->getStructuredBlock()
                                        ->getCreditorReferenceInformation()
                                        ->getCode()
                                );

                                self::assertEquals(
                                    'Additional Remittance Information V2',
                                    $transactionDetail
                                        ->getRemittanceInformation()
                                        ->getStructuredBlock()
                                        ->getAdditionalRemittanceInformation()
                                );

                                break;
                            case 2:
                                // Legacy : ref number from the first unstructured block
                                self::assertEquals(
                                    'Unstructured Remittance Information V3 block 1',
                                    $transactionDetail
                                        ->getRemittanceInformation()
                                        ->getMessage()
                                );

                                // First unstructured block
                                self::assertEquals(
                                    'Unstructured Remittance Information V3 block 1',
                                    $transactionDetail
                                        ->getRemittanceInformation()
                                        ->getUnstructuredBlocks()[0]
                                        ->getMessage()
                                );

                                // Second unstructured block
                                self::assertEquals(
                                    'Unstructured Remittance Information V3 block 2',
                                    $transactionDetail
                                        ->getRemittanceInformation()
                                        ->getUnstructuredBlocks()[1]
                                        ->getMessage()
                                );

                                // Ref number from the first structured block
                                self::assertEquals(
                                    'Ref number V3 block 1',
                                    $transactionDetail
                                        ->getRemittanceInformation()
                                        ->getStructuredBlocks()[0]
                                        ->getCreditorReferenceInformation()
                                        ->getRef()
                                );

                                // Ref number from the second structured block
                                self::assertEquals(
                                    'Ref number V3 block 2',
                                    $transactionDetail
                                        ->getRemittanceInformation()
                                        ->getStructuredBlocks()[1]
                                        ->getCreditorReferenceInformation()
                                        ->getRef()
                                );

                                // Code from the first structured block
                                self::assertEquals(
                                    'SCOR',
                                    $transactionDetail
                                        ->getRemittanceInformation()
                                        ->getStructuredBlocks()[0]
                                        ->getCreditorReferenceInformation()
                                        ->getCode()
                                );

                                // Code from the second structured block
                                self::assertEquals(
                                    'SCOR',
                                    $transactionDetail
                                        ->getRemittanceInformation()
                                        ->getStructuredBlocks()[1]
                                        ->getCreditorReferenceInformation()
                                        ->getCode()
                                );

                                // Additional remittance information from the first structured block
                                self::assertEquals(
                                    'Additional Remittance Information V3 block 1',
                                    $transactionDetail
                                        ->getRemittanceInformation()
                                        ->getStructuredBlocks()[0]
                                        ->getAdditionalRemittanceInformation()
                                );

                                // Additional remittance information from the second structured block
                                self::assertEquals(
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
