<?php

declare(strict_types=1);

namespace Genkgo\TestCamt\Unit\Camt053;

use DateTimeImmutable;
use DOMDocument;
use Genkgo\Camt\Camt053\DTO as Camt053DTO;
use Genkgo\Camt\Camt053\MessageFormat;
use Genkgo\Camt\DTO;
use Genkgo\Camt\DTO\Message;
use Genkgo\Camt\DTO\OrganisationIdentification;
use Genkgo\Camt\DTO\RecordWithBalances;
use Genkgo\Camt\Exception\InvalidMessageException;
use Genkgo\TestCamt\AbstractTestCase;

class EndToEndTest extends AbstractTestCase
{
    protected function getV2Message(): Message
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->load(__DIR__ . '/Stubs/camt053.v2.minimal.xml');

        return (new MessageFormat\V02())->getDecoder()->decode($dom);
    }

    protected function getV2UltimateMessage(): Message
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->load(__DIR__ . '/Stubs/camt053.v2.minimal.ultimate.xml');

        return (new MessageFormat\V02())->getDecoder()->decode($dom);
    }

    protected function getV3Message(): Message
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->load(__DIR__ . '/Stubs/camt053.v3.xml');

        return (new MessageFormat\V03())->getDecoder()->decode($dom);
    }

    protected function getV4Message(): Message
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->load(__DIR__ . '/Stubs/camt053.v4.xml');

        return (new MessageFormat\V04())->getDecoder()->decode($dom);
    }

    public function testWrongDocument(): Message
    {
        $this->expectException(InvalidMessageException::class);

        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->load(__DIR__ . '/Stubs/camt053.v2.wrong.xml');

        return (new MessageFormat\V02())->getDecoder()->decode($dom);
    }

    public function testFiveDecimalsStatement(): void
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->load(__DIR__ . '/Stubs/camt053.v2.five.decimals.xml');
        self::assertInstanceOf(Message::class, (new MessageFormat\V02())->getDecoder()->decode($dom));
    }

    public function testV3Document(): void
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->load(__DIR__ . '/Stubs/camt053.v3.xml');
        self::assertInstanceOf(Message::class, (new MessageFormat\V03())->getDecoder()->decode($dom));
    }

    public function testV4Document(): void
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->load(__DIR__ . '/Stubs/camt053.v4.xml');
        self::assertInstanceOf(Message::class, (new MessageFormat\V04())->getDecoder()->decode($dom));
    }

    public function testGroupHeader(): void
    {
        $messages = [
            $this->getV2Message(),
            $this->getV3Message(),
            $this->getV4Message(),
            $this->getV2UltimateMessage(),
        ];

        /** @var Message $message */
        foreach ($messages as $message) {
            $groupHeader = $message->getGroupHeader();

            self::assertInstanceOf(DTO\GroupHeader::class, $groupHeader);
            self::assertEquals('CAMT053RIB000000000001', $groupHeader->getMessageId());
            self::assertEquals(new DateTimeImmutable('2015-03-10T18:43:50+00:00'), $groupHeader->getCreatedOn());
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

    public function testStatements(): void
    {
        $messages = [
            $this->getV2Message(),
            $this->getV3Message(),
            $this->getV4Message(),
            $this->getV2UltimateMessage(),
        ];

        foreach ($messages as $message) {
            $statements = $message->getRecords();

            self::assertCount(1, $statements);
            foreach ($statements as $statement) {
                self::assertInstanceOf(Camt053DTO\Statement::class, $statement);
                self::assertEquals('253EURNL26VAYB8060476890', $statement->getId());
                self::assertEquals('NL26VAYB8060476890', $statement->getAccount()->getIdentification());
                self::assertEquals(new DateTimeImmutable('2015-03-10T18:43:50+00:00'), $statement->getCreatedOn());

                self::assertEquals('12312', $statement->getElectronicSequenceNumber());
                self::assertEquals('12312', $statement->getLegalSequenceNumber());
                self::assertEquals('CODU', $statement->getCopyDuplicateIndicator());
                self::assertEquals(new DateTimeImmutable('2007-10-18T08:00:00+01:00'), $statement->getFromDate());
                self::assertEquals(new DateTimeImmutable('2007-10-18T12:30:00+01:00'), $statement->getToDate());
                self::assertEquals('Additional Information', $statement->getAdditionalInformation());
            }
        }

        $statementV4 = $messages[2]->getRecords()[0];
        self::assertInstanceOf(DTO\Pagination::class, $statementV4->getPagination());
        self::assertEquals('2', $statementV4->getPagination()->getPageNumber());
        self::assertTrue($statementV4->getPagination()->isLastPage());
    }

    public function testBalance(): void
    {
        $messages = [
            $this->getV2Message(),
            $this->getV3Message(),
            $this->getV4Message(),
            $this->getV2UltimateMessage(),
        ];

        foreach ($messages as $message) {
            $statements = $message->getRecords();

            self::assertCount(1, $statements);
            /** @var RecordWithBalances $statement */
            foreach ($statements as $statement) {
                $balances = $statement->getBalances();
                self::assertCount(2, $balances);

                foreach ($balances as $item => $balance) {
                    if ($item === 0) {
                        self::assertEquals(1815, $balance->getAmount()->getAmount());
                        self::assertEquals('EUR', $balance->getAmount()->getCurrency()->getCode());
                        self::assertEquals('opening', $balance->getType());
                    }

                    if ($item === 1) {
                        self::assertEquals(-2700, $balance->getAmount()->getAmount());
                        self::assertEquals('SEK', $balance->getAmount()->getCurrency()->getCode());
                        self::assertEquals('closing', $balance->getType());
                    }
                }
            }
        }
    }

    public function testEntries(): void
    {
        $messages = [
            $this->getV2Message(),
            $this->getV3Message(),
            $this->getV4Message(),
            $this->getV2UltimateMessage(),
        ];

        foreach ($messages as $message) {
            $statements = $message->getRecords();

            self::assertCount(1, $statements);
            foreach ($statements as $statement) {
                $entries = $statement->getEntries();
                self::assertCount(1, $entries);

                foreach ($entries as $entry) {
                    self::assertEquals(885, $entry->getAmount()->getAmount());
                    self::assertEquals('EUR', $entry->getAmount()->getCurrency()->getCode());
                    self::assertEquals('2014-12-31', $entry->getBookingDate()->format('Y-m-d'));
                    self::assertEquals('2015-01-02', $entry->getValueDate()->format('Y-m-d'));

                    $details = $entry->getTransactionDetails();
                    self::assertCount(1, $details);
                    foreach ($details as $detail) {
                        $parties = $detail->getRelatedParties();
                        self::assertCount(2, $parties);

                        foreach ($parties as $party) {
                            if ($party->getRelatedPartyType() instanceof DTO\Creditor) {
                                if ($party->getRelatedPartyType() instanceof DTO\UltimateCreditor) {
                                    self::assertEquals('CREDITOR NAME NM', $party->getRelatedPartyType()->getName());
                                    self::assertEquals(['CREDITOR NAME', 'CREDITOR ADD'], $party->getRelatedPartyType()->getAddress()->getAddressLines());
                                } else {
                                    self::assertEquals('Company Name', $party->getRelatedPartyType()->getName());
                                    self::assertEquals('NL', $party->getRelatedPartyType()->getAddress()->getCountry());
                                    self::assertEquals([], $party->getRelatedPartyType()->getAddress()->getAddressLines());
                                    self::assertEquals('NL56AGDH9619008421', (string) $party->getAccount()->getIdentification());
                                }
                            } elseif ($party->getRelatedPartyType() instanceof DTO\Debtor) {
                                if ($party->getRelatedPartyType() instanceof DTO\UltimateDebtor) {
                                    self::assertEquals('DEBTOR NAME NM', $party->getRelatedPartyType()->getName());
                                    self::assertEquals(['DEBTOR NAME', 'DEBTOR ADD'], $party->getRelatedPartyType()->getAddress()->getAddressLines());
                                } else {
                                    self::assertEquals('NAME NAME', $party->getRelatedPartyType()->getName());
                                    self::assertEquals('NL', $party->getRelatedPartyType()->getAddress()->getCountry());
                                    self::assertEquals(['ADDR ADDR 10', '2000 ANTWERPEN'], $party->getRelatedPartyType()->getAddress()->getAddressLines());
                                    self::assertEquals('NL56AGDH9619008421', (string) $party->getAccount()->getIdentification());
                                }
                            }
                        }

                        $reference = $detail->getReference();
                        self::assertEquals('LegalSequenceNumber', $reference->getProprietaries()[0]->getType());
                        self::assertEquals('100', $reference->getProprietaries()[0]->getReference());
                        self::assertNull($reference->getMandateId());

                        $remittanceInformation = $detail->getRemittanceInformation();
                        self::assertEquals('4654654654654654', $remittanceInformation->getCreditorReferenceInformation()->getRef());
                    }
                }
            }
        }
    }

    public function testStructuredMessage(): void
    {
        $messages = [
            $this->getV2Message(),
            $this->getV3Message(),
            $this->getV4Message(),
            $this->getV2UltimateMessage(),
        ];

        foreach ($messages as $message) {
            $statements = $message->getRecords();

            self::assertCount(1, $statements);
            foreach ($statements as $statement) {
                $entries = $statement->getEntries();
                self::assertCount(1, $entries);

                foreach ($entries as $entry) {
                    $details = $entry->getTransactionDetails();
                    self::assertCount(1, $details);
                    foreach ($details as $detail) {
                        $remittanceInformation = $detail->getRemittanceInformation();
                        self::assertEquals('4654654654654654', $remittanceInformation->getMessage());
                    }
                }
            }
        }
    }
}
