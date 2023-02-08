<?php

declare(strict_types=1);

namespace Genkgo\TestCamt\Unit\Decoder;

use Genkgo\Camt\Camt053;
use Genkgo\Camt\Decoder;
use Genkgo\Camt\Decoder\Record;
use Genkgo\Camt\DTO;
use PHPUnit\Framework;
use SimpleXMLElement;

class RecordTest extends Framework\TestCase
{
    /**
     * @var Decoder\Entry&Framework\MockObject\MockObject
     */
    private $mockedEntryDecoder;

    private Record $decoder;

    protected function setUp(): void
    {
        $this->mockedEntryDecoder = $this->createMock(Decoder\Entry::class);
        $this->decoder = new Record($this->mockedEntryDecoder, new Decoder\Date());
    }

    public function testItDoesNotAddBalancesIfThereAreNoneInXml(): void
    {
        $record = $this->createMock(Camt053\DTO\Statement::class);

        $record
            ->expects(self::never())
            ->method('addBalance')
            ->with(self::anything());

        $xmlRecord = new SimpleXMLElement('<content></content>');
        $this->decoder->addBalances($record, $xmlRecord);
    }

    public function testItAddsBalancesIfThereArePresentInXml(): void
    {
        $record = $this->createMock(Camt053\DTO\Statement::class);

        $record
            ->expects(self::exactly(2))
            ->method('addBalance')
            ->with(self::isInstanceOf(DTO\Balance::class));

        $this->decoder->addBalances($record, $this->getXmlRecord());
    }

    public function testItAddsNoEntriesIfThereAreNoneInXml(): void
    {
        $record = $this->createMock(DTO\Record::class);

        $record
            ->expects(self::never())
            ->method('addEntry')
            ->with(self::anything());

        $this->mockedEntryDecoder
            ->expects(self::never())
            ->method('addTransactionDetails')
            ->with(
                self::anything(),
                self::anything(),
            );

        $xmlRecord = new SimpleXMLElement('<content></content>');

        $this->decoder->addEntries($record, $xmlRecord);
    }

    public function testItAddsEntriesIfThereArePresentInXml(): void
    {
        $record = $this->createMock(DTO\Record::class);

        $record
            ->expects(self::once())
            ->method('addEntry')
            ->with(self::isInstanceOf(DTO\Entry::class));

        $this->mockedEntryDecoder
            ->expects(self::once())
            ->method('addTransactionDetails')
            ->with(
                self::isInstanceOf(DTO\Entry::class),
                self::isInstanceOf(SimpleXMLElement::class),
            );

        $this->decoder->addEntries($record, $this->getXmlRecord());
    }

    private function getXmlRecord(): SimpleXMLElement
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
    <Bal>
        <Amt Ccy="EUR">80.22</Amt>
        <Dt>
            <Dt>2014-12-30</Dt>
        </Dt>
        <Tp>
            <CdOrPrtry>
                <Cd>CLAV</Cd>
            </CdOrPrtry>
        </Tp>
        <CdtDbtInd>DBIT</CdtDbtInd>
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

        return new SimpleXMLElement($xmlContent);
    }
}
