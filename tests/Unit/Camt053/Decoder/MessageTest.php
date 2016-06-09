<?php

namespace Genkgo\Camt\Unit\Camt053\Decoder;

use Genkgo\Camt\AbstractTestCase;
use Genkgo\Camt\Camt053\Decoder;
use Genkgo\Camt\Camt053\DTO;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;

class MessageTest extends AbstractTestCase
{
    /** @var ObjectProphecy */
    private $mockedStatementDecoder;

    /** @var Decoder\Message */
    private $decoder;

    public function setUp()
    {
        $entry = $this->prophesize(Decoder\Entry::class);
        $this->mockedStatementDecoder = $this
            ->prophesize(Decoder\Statement::class)
            ->willBeConstructedWith([$entry->reveal()])
        ;
        $this->decoder = new Decoder\Message($this->mockedStatementDecoder->reveal());
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
    public function it_adds_statements()
    {
        $message = $this->prophesize(DTO\Message::class);

        $this->mockedStatementDecoder->addBalances(
            Argument::type(DTO\Statement::class),
            Argument::type('\SimpleXMLElement')
        )->shouldBeCalled();
        $this->mockedStatementDecoder->addEntries(
            Argument::type(DTO\Statement::class),
            Argument::type('\SimpleXMLElement')
        )->shouldBeCalled();

        $message->setStatements(Argument::that(function ($argument) {
            return is_array($argument) && $argument[0] instanceof DTO\Statement;
        }))->shouldBeCalled();

        $this->decoder->addStatements($message->reveal(), $this->getXmlMessage());
    }

    private function getXmlMessage()
    {
        $xmlContent = <<<XML
<content>
    <BkToCstmrStmt>
        <GrpHdr>
            <MsgId>CAMT053RIB000000000001</MsgId>
            <CreDtTm>2015-03-10T18:43:50+00:00</CreDtTm>
        </GrpHdr>
        <Stmt>
            <Id>253EURNL26VAYB8060476890</Id>
            <CreDtTm>2015-03-10T18:43:50+00:00</CreDtTm>
            <Acct>
                <Id>
                    <IBAN>NL26VAYB8060476890</IBAN>
                </Id>
            </Acct>
        </Stmt>
    </BkToCstmrStmt>
</content>

XML;

        return new \SimpleXMLElement($xmlContent);
    }
}
