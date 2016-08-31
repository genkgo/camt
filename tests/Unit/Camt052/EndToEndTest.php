<?php

namespace Genkgo\Camt\Unit\Camt052;

use \DateTimeImmutable;
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

    protected function getV2OtherAccountMessage()
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->load(__DIR__.'/Stubs/camt052.v2.other-account.xml');

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
            $this->assertEquals(new DateTimeImmutable('2007-10-18T12:30:00+01:00'), $groupHeader->getCreatedOn());
            $this->assertEquals('Group header additional information', $groupHeader->getAdditionalInformation());
            $msgRecipient = $groupHeader->getMessageRecipient();
            $this->assertInstanceOf(DTO\Recipient::class, $msgRecipient);
            $this->assertEquals('COMPANY BVBA', $msgRecipient->getName());
            $this->assertEquals('NL', $msgRecipient->getCountryOfResidence());
            $this->assertInstanceOf(DTO\Address::class, $msgRecipient->getAddress());
            $this->assertEquals('12 Oxford Street', $msgRecipient->getAddress()->getStreetName());
            $this->assertEquals('UK', $msgRecipient->getAddress()->getCountry());
            $this->assertInstanceOf(DTO\Identification::class, $msgRecipient->getIdentification());
            $this->assertInstanceOf(DTO\OrganisationIdentification::class, $msgRecipient->getIdentification());
            $this->assertEquals('DABAIE2D', $msgRecipient->getIdentification()->getBic());
            $this->assertEquals('Some other Id', $msgRecipient->getIdentification()->getOtherId());
            $this->assertEquals('Some other Issuer', $msgRecipient->getIdentification()->getOtherIssuer());
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
                $this->assertEquals(new DateTimeImmutable('2007-10-18T12:30:00+01:00'), $report->getCreatedOn());
                $this->assertEquals('12312', $report->getElectronicSequenceNumber());
                $this->assertEquals('12312', $report->getLegalSequenceNumber());
                $this->assertEquals('CODU', $report->getCopyDuplicateIndicator());
                $this->assertEquals(new DateTimeImmutable('2007-10-18T08:00:00+01:00'), $report->getFromDate());
                $this->assertEquals(new DateTimeImmutable('2007-10-18T12:30:00+01:00'), $report->getToDate());
                $this->assertEquals('Additional Information', $report->getAdditionalInformation());
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
                    $this->assertEquals('Credit', $entry->getAdditionalInfo());
                }
            }
        }

        $reportV4 = $messages[2]->getRecords()[0];
        $this->assertInstanceOf(DTO\Pagination::class, $reportV4->getPagination());
        $this->assertEquals('2', $reportV4->getPagination()->getPageNumber());
        $this->assertEquals(true, $reportV4->getPagination()->isLastPage());
    }

    public function testRelatedAgents()
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

                /** @var \Genkgo\Camt\DTO\Entry $entry */
                foreach ($entries as $entry) {
                    $this->assertCount(1, $entry->getTransactionDetails());
                    foreach ($entry->getTransactionDetails() as $detail) {
                        $this->assertCount(2, $detail->getRelatedAgents());

                        foreach ($detail->getRelatedAgents() as $relatedAgent) {
                            $this->assertEquals('BANKCHZHXXX', $relatedAgent->getRelatedAgentType()->getBIC());
                            $this->assertEquals('Some bank', $relatedAgent->getRelatedAgentType()->getName());
                        }
                    }
                }
            }
        }
    }

    public function testOtherAccount()
    {
        $messages = [
            $this->getV2OtherAccountMessage()
        ];

        foreach ($messages as $message) {
            $reports = $message->getRecords();

            $this->assertCount(1, $reports);
            foreach ($reports as $report) {
                $entries = $report->getEntries();
                $this->assertCount(1, $entries);

                /** @var DTO\Entry $entry */
                foreach ($entries as $entry) {
                    $parties = $entry->getTransactionDetail()->getRelatedParties();

                    foreach ($parties as $party) {
                        $this->assertInstanceOf(DTO\OtherAccount::class, $party->getAccount());
                    }
                }
            }
        }
    }

    public function testRelatedParties()
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
                    $details = $entry->getTransactionDetails();
                    $this->assertCount(1, $details);

                    foreach ($details as $detail) {
                        $parties = $detail->getRelatedParties();
                        $this->assertCount(2, $parties);

                        foreach ($parties as $party) {
                            if ($party->getRelatedPartyType() instanceof DTO\Creditor) {
                                $this->assertEquals('Company Name', $party->getRelatedPartyType()->getName());
                                $this->assertEquals('NL', $party->getRelatedPartyType()->getAddress()->getCountry());
                                $this->assertEquals([], $party->getRelatedPartyType()->getAddress()->getAddressLines());
                                $this->assertEquals('NL56AGDH9619008421', (string)$party->getAccount()->getIdentification());
                            } elseif ($party->getRelatedPartyType() instanceof DTO\Debtor) {
                                $this->assertEquals('NAME NAME', $party->getRelatedPartyType()->getName());
                                $this->assertEquals('NL', $party->getRelatedPartyType()->getAddress()->getCountry());
                                $this->assertEquals(['ADDR ADDR 10', '2000 ANTWERPEN'], $party->getRelatedPartyType()->getAddress()->getAddressLines());
                                $this->assertEquals('NL56AGDH9619008421', (string)$party->getAccount()->getIdentification());
                            }
                        }
                    }
                }
            }
        }
    }

    public function testProprietaryBankTransactionCode()
    {
        $messages = [
            $this->getV2Message()
        ];

        foreach ($messages as $message) {
            $reports = $message->getRecords();

            $this->assertCount(1, $reports);
            foreach ($reports as $report) {
                $entries = $report->getEntries();
                $this->assertCount(1, $entries);

                /** @var DTO\Entry $entry */
                foreach ($entries as $entry) {
                    $this->assertInstanceOf(DTO\BankTransactionCode::class, $entry->getBankTransactionCode());
                    $this->assertInstanceOf(DTO\ProprietaryBankTransactionCode::class, $entry->getBankTransactionCode()->getProprietary());

                    $this->assertEquals('XXXX+000+0000+000', $entry->getBankTransactionCode()->getProprietary()->getCode());
                    $this->assertEquals('ZKA', $entry->getBankTransactionCode()->getProprietary()->getIssuer());

                    $this->assertCount(1, $entry->getTransactionDetails());

                    foreach ($entry->getTransactionDetails() as $details) {
                        $this->assertInstanceOf(DTO\BankTransactionCode::class, $details->getBankTransactionCode());
                        $this->assertInstanceOf(DTO\ProprietaryBankTransactionCode::class, $details->getBankTransactionCode()->getProprietary());

                        $this->assertEquals('XXXX+000+0000+000', $details->getBankTransactionCode()->getProprietary()->getCode());
                        $this->assertEquals('ZKA', $details->getBankTransactionCode()->getProprietary()->getIssuer());
                    }
                }
            }
        }
    }
}
