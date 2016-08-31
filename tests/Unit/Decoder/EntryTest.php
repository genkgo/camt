<?php

namespace Genkgo\Camt\Unit\Decoder;

use Genkgo\Camt\AbstractTestCase;
use Genkgo\Camt\Decoder;
use Genkgo\Camt\DTO;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;

class EntryTest extends AbstractTestCase
{
    /** @var ObjectProphecy */
    private $mockedEntryTransactionDetailDecoder;

    /** @var Decoder\Entry */
    private $decoder;

    public function setUp()
    {
        $this->mockedEntryTransactionDetailDecoder = $this->prophesize(Decoder\EntryTransactionDetail::class);
        $this->decoder = new Decoder\Entry($this->mockedEntryTransactionDetailDecoder->reveal());
    }

    /**
     * @test
     */
    public function it_does_not_add_transaction_details_if_there_is_none_in_xml()
    {
        $entry = $this->prophesize(DTO\Entry::class);
        $entry->addTransactionDetail(Argument::any())->shouldNotBeCalled();

        $xmlEntry = new \SimpleXMLElement('<content></content>');
        $this->decoder->addTransactionDetails($entry->reveal(), $xmlEntry);
    }

    /**
     * @test
     */
    public function it_adds_transaction_details_if_there_are_present_in_xml()
    {
        $entry = $this->prophesize(DTO\Entry::class);
        $this->mockedEntryTransactionDetailDecoder->addReferences(
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
        $entry->addTransactionDetail(Argument::type(DTO\EntryTransactionDetail::class))->shouldBeCalled();

        $this->decoder->addTransactionDetails($entry->reveal(), $this->getXmlEntry());
    }

    private function getXmlEntry()
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

        return new \SimpleXMLElement($xmlContent);
    }
}
