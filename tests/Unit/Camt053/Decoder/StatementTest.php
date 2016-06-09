<?php

namespace Genkgo\Camt\Unit\Camt053\Decoder;

use Genkgo\Camt\AbstractTestCase;
use Genkgo\Camt\Camt053\Decoder;
use Genkgo\Camt\Camt053\DTO;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;

class StatementTest extends AbstractTestCase
{
    /** @var ObjectProphecy */
    private $mockedEntryDecoder;

    /** @var Decoder\Statement */
    private $decoder;

    public function setUp()
    {
        $entryTransactionDetail = $this->prophesize(Decoder\EntryTransactionDetail::class);
        $this->mockedEntryDecoder = $this
            ->prophesize(Decoder\Entry::class)
            ->willBeConstructedWith([$entryTransactionDetail->reveal()])
        ;
        $this->decoder = new Decoder\Statement($this->mockedEntryDecoder->reveal());
    }

    /**
     * @test
     */
    public function it_does_not_add_balances_if_there_are_none_in_xml()
    {
        $statement = $this->prophesize(DTO\Statement::class);
        $statement->addBalance(Argument::any())->shouldNotBeCalled();

        $xmlStatement = new \SimpleXMLElement('<content></content>');
        $this->decoder->addBalances($statement->reveal(), $xmlStatement);
    }

    /**
     * @test
     */
    public function it_adds_balances_if_there_are_present_in_xml()
    {
        $statement = $this->prophesize(DTO\Statement::class);
        $statement->addBalance(Argument::type(DTO\Balance::class))->shouldBeCalled();

        $this->decoder->addBalances($statement->reveal(), $this->getXmlStatement());
    }

    /**
     * @test
     */
    public function it_adds_no_entries_if_there_are_none_in_xml()
    {
        $statement = $this->prophesize(DTO\Statement::class);
        $this->mockedEntryDecoder->addTransactionDetails(Argument::any(), Argument::any())->shouldNotBeCalled();
        $statement->addEntry(Argument::any())->shouldNotBeCalled();
        $xmlStatement = new \SimpleXMLElement('<content></content>');

        $this->decoder->addEntries($statement->reveal(), $xmlStatement);
    }

    /**
     * @test
     */
    public function it_adds_entries_if_there_are_present_in_xml()
    {
        $statement = $this->prophesize(DTO\Statement::class);
        $this
            ->mockedEntryDecoder
            ->addTransactionDetails(
                Argument::type(DTO\Entry::class),
                Argument::type('\SimpleXMLElement')
            )
            ->shouldBeCalled()
        ;
        $statement->addEntry(Argument::type(DTO\Entry::class))->shouldBeCalled();

        $this->decoder->addEntries($statement->reveal(), $this->getXmlStatement());
    }

    private function getXmlStatement()
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
