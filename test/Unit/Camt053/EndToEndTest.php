<?php

declare(strict_types=1);

namespace Genkgo\TestCamt\Unit\Camt053;

use DateTimeImmutable;
use DOMDocument;
use Genkgo\Camt\DTO\Message;
use Genkgo\Camt\DTO\OrganisationIdentification;
use Genkgo\Camt\DTO\RecordWithBalances;
use Genkgo\TestCamt\AbstractTestCase;
use Genkgo\Camt\Camt053\MessageFormat;
use Genkgo\Camt\Camt053\DTO as Camt053DTO;
use Genkgo\Camt\DTO;
use Genkgo\Camt\Exception\InvalidMessageException;

class EndToEndTest extends AbstractTestCase
{
    protected function getV2Message(): Message
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->load(__DIR__ . '/Stubs/camt053.v2.minimal.xml');

        return (new MessageFormat\V02)->getDecoder()->decode($dom);
    }

    protected function getV2UltimateMessage(): Message
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->load(__DIR__ . '/Stubs/camt053.v2.minimal.ultimate.xml');

        return (new MessageFormat\V02)->getDecoder()->decode($dom);
    }

    protected function getV3Message(): Message
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->load(__DIR__ . '/Stubs/camt053.v3.xml');

        return (new MessageFormat\V03)->getDecoder()->decode($dom);
    }

    protected function getV4Message(): Message
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->load(__DIR__ . '/Stubs/camt053.v4.xml');

        return (new MessageFormat\V04)->getDecoder()->decode($dom);
    }

    public function testWrongDocument(): Message
    {
        $this->expectException(InvalidMessageException::class);

        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->load(__DIR__ . '/Stubs/camt053.v2.wrong.xml');

        return (new MessageFormat\V02)->getDecoder()->decode($dom);
    }

    public function testFiveDecimalsStatement(): void
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->load(__DIR__ . '/Stubs/camt053.v2.five.decimals.xml');
        $this->assertInstanceOf(Message::class, (new MessageFormat\V02)->getDecoder()->decode($dom));
    }

    public function testV3Document(): void
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->load(__DIR__ . '/Stubs/camt053.v3.xml');
        $this->assertInstanceOf(Message::class, (new MessageFormat\V03)->getDecoder()->decode($dom));
    }

    public function testV4Document(): void
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->load(__DIR__ . '/Stubs/camt053.v4.xml');
        $this->assertInstanceOf(Message::class, (new MessageFormat\V04)->getDecoder()->decode($dom));
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

            $this->assertInstanceOf(DTO\GroupHeader::class, $groupHeader);
            $this->assertEquals('CAMT053RIB000000000001', $groupHeader->getMessageId());
            $this->assertEquals(new DateTimeImmutable('2015-03-10T18:43:50+00:00'), $groupHeader->getCreatedOn());
            $this->assertEquals('Group header additional information', $groupHeader->getAdditionalInformation());
            $msgRecipient = $groupHeader->getMessageRecipient();
            $this->assertInstanceOf(DTO\Recipient::class, $msgRecipient);
            $this->assertEquals('COMPANY BVBA', $msgRecipient->getName());
            $this->assertEquals('NL', $msgRecipient->getCountryOfResidence());
            $this->assertInstanceOf(DTO\Address::class, $msgRecipient->getAddress());
            $this->assertEquals('12 Oxford Street', $msgRecipient->getAddress()->getStreetName());
            $this->assertEquals('UK', $msgRecipient->getAddress()->getCountry());

            /** @var OrganisationIdentification $identification */
            $identification = $msgRecipient->getIdentification();
            $this->assertInstanceOf(DTO\Identification::class, $identification);
            $this->assertEquals('DABAIE2D', $identification->getBic());
            $this->assertEquals('Some other Id', $identification->getOtherId());
            $this->assertEquals('Some other Issuer', $identification->getOtherIssuer());
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

            $this->assertCount(1, $statements);
            foreach ($statements as $statement) {
                $this->assertInstanceOf(Camt053DTO\Statement::class, $statement);
                $this->assertEquals('253EURNL26VAYB8060476890', $statement->getId());
                $this->assertEquals('NL26VAYB8060476890', $statement->getAccount()->getIdentification());
                $this->assertEquals(new DateTimeImmutable('2015-03-10T18:43:50+00:00'), $statement->getCreatedOn());

                $this->assertEquals('12312', $statement->getElectronicSequenceNumber());
                $this->assertEquals('12312', $statement->getLegalSequenceNumber());
                $this->assertEquals('CODU', $statement->getCopyDuplicateIndicator());
                $this->assertEquals(new DateTimeImmutable('2007-10-18T08:00:00+01:00'), $statement->getFromDate());
                $this->assertEquals(new DateTimeImmutable('2007-10-18T12:30:00+01:00'), $statement->getToDate());
                $this->assertEquals('Additional Information', $statement->getAdditionalInformation());
            }
        }

        $statementV4 = $messages[2]->getRecords()[0];
        $this->assertInstanceOf(DTO\Pagination::class, $statementV4->getPagination());
        $this->assertEquals('2', $statementV4->getPagination()->getPageNumber());
        $this->assertEquals(true, $statementV4->getPagination()->isLastPage());
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

            $this->assertCount(1, $statements);
            /** @var RecordWithBalances $statement */
            foreach ($statements as $statement) {
                $balances = $statement->getBalances();
                $this->assertCount(2, $balances);

                foreach ($balances as $item => $balance) {
                    if ($item === 0) {
                        $this->assertEquals(1815, $balance->getAmount()->getAmount());
                        $this->assertEquals('EUR', $balance->getAmount()->getCurrency()->getCode());
                        $this->assertEquals('opening', $balance->getType());
                    }

                    if ($item === 1) {
                        $this->assertEquals(-2700, $balance->getAmount()->getAmount());
                        $this->assertEquals('SEK', $balance->getAmount()->getCurrency()->getCode());
                        $this->assertEquals('closing', $balance->getType());
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

            $this->assertCount(1, $statements);
            foreach ($statements as $statement) {
                $entries = $statement->getEntries();
                $this->assertCount(1, $entries);

                foreach ($entries as $entry) {
                    $this->assertEquals(885, $entry->getAmount()->getAmount());
                    $this->assertEquals('EUR', $entry->getAmount()->getCurrency()->getCode());
                    $this->assertEquals('2014-12-31', $entry->getBookingDate()->format('Y-m-d'));
                    $this->assertEquals('2015-01-02', $entry->getValueDate()->format('Y-m-d'));

                    $details = $entry->getTransactionDetails();
                    $this->assertCount(1, $details);
                    foreach ($details as $detail) {
                        $parties = $detail->getRelatedParties();
                        $this->assertCount(2, $parties);

                        foreach ($parties as $party) {
                            if ($party->getRelatedPartyType() instanceof DTO\Creditor) {
                                if ($party->getRelatedPartyType() instanceof DTO\UltimateCreditor) {
                                    $this->assertEquals('CREDITOR NAME NM', $party->getRelatedPartyType()->getName());
                                    $this->assertEquals(["CREDITOR NAME", "CREDITOR ADD"], $party->getRelatedPartyType()->getAddress()->getAddressLines());
                                } else {
                                    $this->assertEquals('Company Name', $party->getRelatedPartyType()->getName());
                                    $this->assertEquals('NL', $party->getRelatedPartyType()->getAddress()->getCountry());
                                    $this->assertEquals([], $party->getRelatedPartyType()->getAddress()->getAddressLines());
                                    $this->assertEquals('NL56AGDH9619008421', (string) $party->getAccount()->getIdentification());
                                }
                            } elseif ($party->getRelatedPartyType() instanceof DTO\Debtor) {
                                if ($party->getRelatedPartyType() instanceof DTO\UltimateDebtor) {
                                    $this->assertEquals('DEBTOR NAME NM', $party->getRelatedPartyType()->getName());
                                    $this->assertEquals(["DEBTOR NAME", "DEBTOR ADD"], $party->getRelatedPartyType()->getAddress()->getAddressLines());
                                } else {
                                    $this->assertEquals('NAME NAME', $party->getRelatedPartyType()->getName());
                                    $this->assertEquals('NL', $party->getRelatedPartyType()->getAddress()->getCountry());
                                    $this->assertEquals(['ADDR ADDR 10', '2000 ANTWERPEN'], $party->getRelatedPartyType()->getAddress()->getAddressLines());
                                    $this->assertEquals('NL56AGDH9619008421', (string) $party->getAccount()->getIdentification());
                                }
                            }
                        }

                        $reference = $detail->getReference();
                        $this->assertEquals('LegalSequenceNumber', $reference->getProprietaries()[0]->getType());
                        $this->assertEquals('100', $reference->getProprietaries()[0]->getReference());
                        $this->assertNull($reference->getMandateId());

                        $remittanceInformation = $detail->getRemittanceInformation();
                        $this->assertEquals('4654654654654654', $remittanceInformation->getCreditorReferenceInformation()->getRef());
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
