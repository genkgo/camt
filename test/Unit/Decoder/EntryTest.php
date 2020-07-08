<?php

declare(strict_types=1);

namespace Genkgo\TestCamt\Unit\Decoder;

use Genkgo\Camt\Decoder;
use Genkgo\Camt\DTO;
use Genkgo\TestCamt\AbstractTestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use SimpleXMLElement;

class EntryTest extends AbstractTestCase
{
    /**
     * @var ObjectProphecy
     */
    private $mockedEntryTransactionDetailDecoder;

    /**
     * @var Decoder\Entry
     */
    private $decoder;

    protected function setUp(): void
    {
        $this->mockedEntryTransactionDetailDecoder = $this->prophesize(Decoder\EntryTransactionDetail::class);
        $this->decoder = new Decoder\Entry($this->mockedEntryTransactionDetailDecoder->reveal());
    }

    public function testItDoesNotAddTransactionDetailsIfThereIsNoneInXml(): void
    {
        $entry = $this->prophesize(DTO\Entry::class);
        $entry->addTransactionDetail(Argument::any())->shouldNotBeCalled();

        $xmlEntry = new SimpleXMLElement('<content></content>');
        $this->decoder->addTransactionDetails($entry->reveal(), $xmlEntry);
    }

    public function testItAddsTransactionDetailsIfThereArePresentInXml(): void
    {
        $entry = $this->prophesize(DTO\Entry::class);
        $this->mockedEntryTransactionDetailDecoder->addReference(
            Argument::type(DTO\EntryTransactionDetail::class),
            Argument::type('\SimpleXMLElement')
        )->shouldBeCalled();
        $this->mockedEntryTransactionDetailDecoder->addRelatedParties(
            Argument::type(DTO\EntryTransactionDetail::class),
            Argument::type('\SimpleXMLElement')
        )->shouldBeCalled();
        $this->mockedEntryTransactionDetailDecoder->addRelatedAgents(
            Argument::type(DTO\EntryTransactionDetail::class),
            Argument::type('\SimpleXMLElement')
        )->shouldBeCalled();
        $this->mockedEntryTransactionDetailDecoder->addRemittanceInformation(
            Argument::type(DTO\EntryTransactionDetail::class),
            Argument::type('\SimpleXMLElement')
        )->shouldBeCalled();
        $this->mockedEntryTransactionDetailDecoder->addRelatedDates(
            Argument::type(DTO\EntryTransactionDetail::class),
            Argument::type('\SimpleXMLElement')
        )->shouldBeCalled();
        $this->mockedEntryTransactionDetailDecoder->addReturnInformation(
            Argument::type(DTO\EntryTransactionDetail::class),
            Argument::type('\SimpleXMLElement')
        )->shouldBeCalled();
        $this->mockedEntryTransactionDetailDecoder->addAdditionalTransactionInformation(
            Argument::type(DTO\EntryTransactionDetail::class),
            Argument::type('\SimpleXMLElement')
        )->shouldBeCalled();
        $this->mockedEntryTransactionDetailDecoder->addBankTransactionCode(
            Argument::type(DTO\EntryTransactionDetail::class),
            Argument::type('\SimpleXMLElement')
        )->shouldBeCalled();
        $this->mockedEntryTransactionDetailDecoder->addCharges(
            Argument::type(DTO\EntryTransactionDetail::class),
            Argument::type('\SimpleXMLElement')
        )->shouldBeCalled();
        $this->mockedEntryTransactionDetailDecoder->addAmountDetails(
            Argument::type(DTO\EntryTransactionDetail::class),
            Argument::type('\SimpleXMLElement'),
            Argument::type('\SimpleXMLElement')
        )->shouldBeCalled();
        $this->mockedEntryTransactionDetailDecoder->addAmount(
            Argument::type(DTO\EntryTransactionDetail::class),
            Argument::type('\SimpleXMLElement'),
            Argument::type('\SimpleXMLElement')
        )->shouldBeCalled();
        $entry->addTransactionDetail(Argument::type(DTO\EntryTransactionDetail::class))->shouldBeCalled();

        $this->decoder->addTransactionDetails($entry->reveal(), $this->getXmlEntry());
    }

    private function getXmlEntry(): SimpleXMLElement
    {
        $xmlContent = <<<XML
<content>
    <NtryDtls>
        <TxDtls>
            <EndToEndId>000000001</EndToEndId>
        </TxDtls>
    </NtryDtls>
</content>
XML;

        return new SimpleXMLElement($xmlContent);
    }
}
