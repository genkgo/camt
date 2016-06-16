<?php

namespace Genkgo\Camt\Unit\Camt052\Decoder;

use Genkgo\Camt\AbstractTestCase;
use Genkgo\Camt\Camt052;
use Genkgo\Camt\DTO;
use Genkgo\Camt\Decoder as DecoderObject;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;

class MessageTest extends AbstractTestCase
{
    /** @var ObjectProphecy */
    private $mockedRecordDecoder;

    /** @var DecoderObject\Message */
    private $decoder;

    public function setUp()
    {
        $entry = $this->prophesize(DecoderObject\Entry::class);
        $this->mockedRecordDecoder = $this
            ->prophesize(DecoderObject\Record::class)
            ->willBeConstructedWith([$entry->reveal()])
        ;
        $this->decoder = new Camt052\Decoder\V01\Message($this->mockedRecordDecoder->reveal());
    }

    /**
     * @test
     */
    public function it_adds_group_header()
    {
        $message = $this->prophesize(DTO\Message::class);
        $message->setGroupHeader(Argument::type(DTO\GroupHeader::class))->shouldBeCalled();

        $this->decoder->addGroupHeader($message->reveal(), $this->getXmlMessage());
    }

    /**
     * @test
     */
    public function it_adds_reports()
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

        $message->setRecords(Argument::that(function ($argument) {
            return is_array($argument) && $argument[0] instanceof Camt052\DTO\Report;
        }))->shouldBeCalled();

        $this->decoder->addRecords($message->reveal(), $this->getXmlMessage());
    }

    private function getXmlMessage()
    {
        $xmlContent = <<<XML
<content>
    <BkToCstmrAcctRptV01>
        <GrpHdr>
            <MsgId>CAMT053RIB000000000001</MsgId>
            <CreDtTm>2015-03-10T18:43:50+00:00</CreDtTm>
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

        return new \SimpleXMLElement($xmlContent);
    }
}
