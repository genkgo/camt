<?php

declare(strict_types=1);

namespace Genkgo\TestCamt\Unit\Camt052;

use DateTimeImmutable;
use DOMDocument;
use Genkgo\Camt\Camt052\DTO as Camt052DTO;
use Genkgo\Camt\Camt052\MessageFormat;
use Genkgo\Camt\DTO;
use Genkgo\Camt\DTO\Entry;
use Genkgo\Camt\DTO\Message;
use Genkgo\Camt\DTO\OrganisationIdentification;
use Genkgo\TestCamt\AbstractTestCase;

class EndToEndTest extends AbstractTestCase
{
    protected function getV1Message(): Message
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->load(__DIR__ . '/Stubs/camt052.v1.xml');

        return (new MessageFormat\V01())->getDecoder()->decode($dom);
    }

    protected function getV2Message(): Message
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->load(__DIR__ . '/Stubs/camt052.v2.xml');

        return (new MessageFormat\V02())->getDecoder()->decode($dom);
    }

    protected function getV2OtherAccountMessage(): Message
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->load(__DIR__ . '/Stubs/camt052.v2.other-account.xml');

        return (new MessageFormat\V02())->getDecoder()->decode($dom);
    }

    protected function getV4Message(): Message
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->load(__DIR__ . '/Stubs/camt052.v4.xml');

        return (new MessageFormat\V04())->getDecoder()->decode($dom);
    }

    protected function getV6Message(): Message
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->load(__DIR__ . '/Stubs/camt052.v6.xml');

        return (new MessageFormat\V06())->getDecoder()->decode($dom);
    }

    public function testGroupHeader(): void
    {
        $messages = [
            $this->getV1Message(),
            $this->getV2Message(),
            $this->getV4Message(),
            $this->getV6Message(),
        ];

        /** @var Message $message */
        foreach ($messages as $message) {
            $groupHeader = $message->getGroupHeader();

            self::assertInstanceOf(DTO\GroupHeader::class, $groupHeader);
            self::assertEquals('AAAASESS-FP-ACCR001', $groupHeader->getMessageId());
            self::assertEquals(new DateTimeImmutable('2007-10-18T12:30:00+01:00'), $groupHeader->getCreatedOn());
            self::assertEquals('Group header additional information', $groupHeader->getAdditionalInformation());
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
    }

    public function testReports(): void
    {
        $messages = [
            $this->getV1Message(),
            $this->getV2Message(),
            $this->getV4Message(),
        ];

        foreach ($messages as $message) {
            $reports = $message->getRecords();

            self::assertCount(1, $reports);
            foreach ($reports as $report) {
                self::assertInstanceOf(Camt052DTO\Report::class, $report);
                self::assertEquals('AAAASESS-FP-ACCR001', $report->getId());
                self::assertEquals('CH2801234000123456789', $report->getAccount()->getIdentification());
                self::assertEquals(new DateTimeImmutable('2007-10-18T12:30:00+01:00'), $report->getCreatedOn());
                self::assertEquals('12312', $report->getElectronicSequenceNumber());
                self::assertEquals('12312', $report->getLegalSequenceNumber());
                self::assertEquals('CODU', $report->getCopyDuplicateIndicator());
                self::assertEquals(new DateTimeImmutable('2007-10-18T08:00:00+01:00'), $report->getFromDate());
                self::assertEquals(new DateTimeImmutable('2007-10-18T12:30:00+01:00'), $report->getToDate());
                self::assertEquals('Additional Information', $report->getAdditionalInformation());
            }
        }
    }

    public function testEntries(): void
    {
        $messages = [
            $this->getV1Message(),
            $this->getV2Message(),
            $this->getV4Message(),
        ];

        foreach ($messages as $message) {
            $reports = $message->getRecords();

            self::assertCount(1, $reports);
            foreach ($reports as $report) {
                $entries = $report->getEntries();
                self::assertCount(1, $entries);

                foreach ($entries as $entry) {
                    self::assertEquals(-20000000, $entry->getAmount()->getAmount());
                    self::assertEquals('SEK', $entry->getAmount()->getCurrency()->getCode());
                    self::assertEquals('2007-10-18', $entry->getBookingDate()->format('Y-m-d'));
                    self::assertEquals('2007-10-18', $entry->getValueDate()->format('Y-m-d'));
                    self::assertEquals('Credit', $entry->getAdditionalInfo());
                }
            }
        }

        $reportV4 = $messages[2]->getRecords()[0];
        self::assertInstanceOf(DTO\Pagination::class, $reportV4->getPagination());
        self::assertEquals('2', $reportV4->getPagination()->getPageNumber());
        self::assertTrue($reportV4->getPagination()->isLastPage());
    }

    public function testRelatedAgents(): void
    {
        $messages = [
            $this->getV2Message(),
        ];

        foreach ($messages as $message) {
            $reports = $message->getRecords();

            self::assertCount(1, $reports);
            foreach ($reports as $report) {
                $entries = $report->getEntries();
                self::assertCount(1, $entries);

                /** @var Entry $entry */
                foreach ($entries as $entry) {
                    self::assertCount(1, $entry->getTransactionDetails());
                    foreach ($entry->getTransactionDetails() as $detail) {
                        self::assertCount(2, $detail->getRelatedAgents());

                        foreach ($detail->getRelatedAgents() as $relatedAgent) {
                            self::assertEquals('BANKCHZHXXX', $relatedAgent->getRelatedAgentType()->getBIC());
                            self::assertEquals('Some bank', $relatedAgent->getRelatedAgentType()->getName());
                        }
                    }
                }
            }
        }
    }

    public function testOtherAccount(): void
    {
        $messages = [
            $this->getV2OtherAccountMessage(),
        ];

        foreach ($messages as $message) {
            $reports = $message->getRecords();

            self::assertCount(1, $reports);
            foreach ($reports as $report) {
                $entries = $report->getEntries();
                self::assertCount(1, $entries);

                /** @var Entry $entry */
                foreach ($entries as $entry) {
                    $parties = $entry->getTransactionDetail()->getRelatedParties();

                    foreach ($parties as $party) {
                        self::assertInstanceOf(DTO\OtherAccount::class, $party->getAccount());
                    }
                }
            }
        }
    }

    public function testRelatedParties(): void
    {
        $messages = [
            $this->getV2Message(),
        ];

        foreach ($messages as $message) {
            $reports = $message->getRecords();

            self::assertCount(1, $reports);
            foreach ($reports as $report) {
                $entries = $report->getEntries();
                self::assertCount(1, $entries);

                foreach ($entries as $entry) {
                    $details = $entry->getTransactionDetails();
                    self::assertCount(1, $details);

                    foreach ($details as $detail) {
                        $parties = $detail->getRelatedParties();
                        self::assertCount(2, $parties);

                        foreach ($parties as $party) {
                            if ($party->getRelatedPartyType() instanceof DTO\Creditor) {
                                self::assertEquals('Company Name', $party->getRelatedPartyType()->getName());
                                self::assertEquals('NL', $party->getRelatedPartyType()->getAddress()->getCountry());
                                self::assertEquals([], $party->getRelatedPartyType()->getAddress()->getAddressLines());
                                self::assertEquals('NL56AGDH9619008421', (string) $party->getAccount()->getIdentification());
                            } elseif ($party->getRelatedPartyType() instanceof DTO\Debtor) {
                                self::assertEquals('NAME NAME', $party->getRelatedPartyType()->getName());
                                self::assertEquals('NL', $party->getRelatedPartyType()->getAddress()->getCountry());
                                self::assertEquals(['ADDR ADDR 10', '2000 ANTWERPEN'], $party->getRelatedPartyType()->getAddress()->getAddressLines());
                                self::assertEquals('NL56AGDH9619008421', (string) $party->getAccount()->getIdentification());
                            }
                        }
                    }
                }
            }
        }
    }

    public function testProprietaryBankTransactionCode(): void
    {
        $messages = [
            $this->getV2Message(),
        ];

        foreach ($messages as $message) {
            $reports = $message->getRecords();

            self::assertCount(1, $reports);
            foreach ($reports as $report) {
                $entries = $report->getEntries();
                self::assertCount(1, $entries);

                /** @var Entry $entry */
                foreach ($entries as $entry) {
                    self::assertInstanceOf(DTO\BankTransactionCode::class, $entry->getBankTransactionCode());
                    self::assertInstanceOf(DTO\ProprietaryBankTransactionCode::class, $entry->getBankTransactionCode()->getProprietary());

                    self::assertEquals('XXXX+000+0000+000', $entry->getBankTransactionCode()->getProprietary()->getCode());
                    self::assertEquals('ZKA', $entry->getBankTransactionCode()->getProprietary()->getIssuer());

                    self::assertCount(1, $entry->getTransactionDetails());

                    foreach ($entry->getTransactionDetails() as $details) {
                        self::assertInstanceOf(DTO\BankTransactionCode::class, $details->getBankTransactionCode());
                        self::assertInstanceOf(DTO\ProprietaryBankTransactionCode::class, $details->getBankTransactionCode()->getProprietary());

                        self::assertEquals('XXXX+000+0000+000', $details->getBankTransactionCode()->getProprietary()->getCode());
                        self::assertEquals('ZKA', $details->getBankTransactionCode()->getProprietary()->getIssuer());
                    }
                }
            }
        }
    }
}
