<?php

declare(strict_types=1);

namespace Genkgo\TestCamt\Unit\Camt052\Decoder;

use Genkgo\Camt\Camt052;
use Genkgo\Camt\Camt052\Decoder\V01\Message;
use Genkgo\Camt\Decoder as DecoderObject;
use Genkgo\Camt\DTO;
use Genkgo\TestCamt\AbstractTestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use SimpleXMLElement;

class MessageTest extends AbstractTestCase
{
    /**
     * @var ObjectProphecy
     */
    private $mockedRecordDecoder;

    /**
     * @var Message
     */
    private $decoder;

    protected function setUp(): void
    {
        $entry = $this->prophesize(DecoderObject\Entry::class);
        $this->mockedRecordDecoder = $this
            ->prophesize(DecoderObject\Record::class)
            ->willBeConstructedWith([$entry->reveal(), new DecoderObject\Date()]);
        $this->decoder = new Message($this->mockedRecordDecoder->reveal(), new DecoderObject\Date());
    }

    public function testItAddsGroupHeader(): void
    {
        $message = $this->prophesize(DTO\Message::class);
        $message->setGroupHeader(Argument::type(DTO\GroupHeader::class))->shouldBeCalled();

        $this->decoder->addGroupHeader($message->reveal(), $this->getXmlMessage());
    }

    public function testItAddsReports(): void
    {
        $message = $this->prophesize(DTO\Message::class);

        $this->mockedRecordDecoder->addBalances(
            Argument::type(Camt052\DTO\Report::class),
            Argument::type('\SimpleXMLElement')
        )->shouldBeCalled();
        $this->mockedRecordDecoder->addEntries(
            Argument::type(Camt052\DTO\Report::class),
            Argument::type('\SimpleXMLElement')
        )->shouldBeCalled();

        $message->setRecords(Argument::that(function ($argument): bool {
            return is_array($argument) && $argument[0] instanceof Camt052\DTO\Report;
        }))->shouldBeCalled();

        $this->decoder->addRecords($message->reveal(), $this->getXmlMessage());
    }

    private function getXmlMessage(): SimpleXMLElement
    {
        $xmlContent = <<<XML
<content>
    <BkToCstmrAcctRptV01>
        <GrpHdr>
            <MsgId>CAMT053RIB000000000001</MsgId>
            <CreDtTm>2015-03-10T18:43:50+00:00</CreDtTm>
            <MsgRcpt>
                <Nm>COMPANY BVBA</Nm>
                <PstlAdr>
                    <StrtNm>12 Oxford Street</StrtNm>
                    <Ctry>UK</Ctry>
                </PstlAdr>
                <Id>
                    <OrgId>
                        <BIC>DABAIE2D</BIC>
                        <IBEI>BCBDFHJNP8</IBEI>
                        <BEI>BTDTRSBA</BEI>
                        <EANGLN>4839402843123</EANGLN>
                        <PrtryId>
                            <Id>Some other Id</Id>
                            <Issr>Some other Issuer</Issr>
                        </PrtryId>
                    </OrgId>
                </Id>
                <CtryOfRes>NL</CtryOfRes>
            </MsgRcpt>
        </GrpHdr>
        <Rpt>
            <Id>253EURNL26VAYB8060476890</Id>
            <CreDtTm>2015-03-10T18:43:50+00:00</CreDtTm>
            <Acct>
                <Id>
                    <PrtryAcct>
                        <Id>50000000054910000003</Id>
                    </PrtryAcct>
                </Id>
            </Acct>
        </Rpt>
    </BkToCstmrAcctRptV01>
</content>
XML;

        return new SimpleXMLElement($xmlContent);
    }
}
