<?php

namespace Genkgo\TestCamt\Unit\Decoder;

use Genkgo\TestCamt\AbstractTestCase;
use Genkgo\Camt\Decoder;
use Genkgo\Camt\DTO;
use Genkgo\Camt\Camt053;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;

class RecordTest extends AbstractTestCase
{
    /** @var ObjectProphecy */
    private $mockedEntryDecoder;

    /** @var Decoder\Record */
    private $decoder;

    public function setUp(): void
    {
        $entryTransactionDetail = $this->prophesize(Decoder\EntryTransactionDetail::class);
        $this->mockedEntryDecoder = $this
            ->prophesize(Decoder\Entry::class)
            ->willBeConstructedWith([$entryTransactionDetail->reveal()])
        ;
        $this->decoder = new Decoder\Record($this->mockedEntryDecoder->reveal(), new Decoder\Date());
    }

    /**
     * @test
     */
    public function it_does_not_add_balances_if_there_are_none_in_xml()
    {
        $record = $this->prophesize(Camt053\DTO\Statement::class);
        $record->addBalance(Argument::any())->shouldNotBeCalled();

        $xmlRecord = new \SimpleXMLElement('<content></content>');
        $this->decoder->addBalances($record->reveal(), $xmlRecord);
    }

    /**
     * @test
     */
    public function it_adds_balances_if_there_are_present_in_xml()
    {
        $record = $this->prophesize(Camt053\DTO\Statement::class);
        $record->addBalance(Argument::type(DTO\Balance::class))->shouldBeCalled();

        $this->decoder->addBalances($record->reveal(), $this->getXmlRecord());
    }

    /**
     * @test
     */
    public function it_adds_no_entries_if_there_are_none_in_xml()
    {
        $record = $this->prophesize(DTO\Record::class);
        $this->mockedEntryDecoder->addTransactionDetails(Argument::any(), Argument::any())->shouldNotBeCalled();
        $record->addEntry(Argument::any())->shouldNotBeCalled();
        $xmlRecord = new \SimpleXMLElement('<content></content>');

        $this->decoder->addEntries($record->reveal(), $xmlRecord);
    }

    /**
     * @test
     */
    public function it_adds_entries_if_there_are_present_in_xml()
    {
        $record = $this->prophesize(DTO\Record::class);
        $this
            ->mockedEntryDecoder
            ->addTransactionDetails(
                Argument::type(DTO\Entry::class),
                Argument::type('\SimpleXMLElement')
            )
            ->shouldBeCalled()
        ;
        $record->addEntry(Argument::type(DTO\Entry::class))->shouldBeCalled();

        $this->decoder->addEntries($record->reveal(), $this->getXmlRecord());
    }

    private function getXmlRecord()
    {
        $xmlContent = <<<XML
<content>
    <Bal>
        <Amt Ccy="EUR">24.22</Amt>
        <Dt>
            <Dt>2014-12-30</Dt>
        </Dt>
        <CdtDbtInd>DBIT</CdtDbtInd>
        <Tp>
            <CdOrPrtry>
                <Cd>OPBD</Cd>
            </CdOrPrtry>
        </Tp>
    </Bal>
    <Ntry>
        <Amt Ccy="EUR">1.42</Amt>
        <BookgDt>
            <Dt></Dt>
        </BookgDt>
        <ValDt>
            <Dt></Dt>
        </ValDt>
        <CdtDbtInd>DBIT</CdtDbtInd>
        <RvslInd>true</RvslInd>
        <NtryRef>lorem</NtryRef>
        <AcctSvcrRef>ipsum</AcctSvcrRef>
        <NtryDtls>
            <Btch>
                <PmtInfId>id</PmtInfId>
            </Btch>
        </NtryDtls>
    </Ntry>
</content>
XML;

        return new \SimpleXMLElement($xmlContent);
    }
}
