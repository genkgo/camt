<?php

declare(strict_types=1);

namespace Genkgo\TestCamt\Unit\Camt053\Decoder;

use Genkgo\Camt\Camt053;
use Genkgo\Camt\Camt053\Decoder\Message;
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

    public function testItAddsStatements(): void
    {
        $message = $this->prophesize(DTO\Message::class);

        $this->mockedRecordDecoder->addBalances(
            Argument::type(Camt053\DTO\Statement::class),
            Argument::type('\SimpleXMLElement')
        )->shouldBeCalled();
        $this->mockedRecordDecoder->addEntries(
            Argument::type(Camt053\DTO\Statement::class),
            Argument::type('\SimpleXMLElement')
        )->shouldBeCalled();

        $message->setRecords(Argument::that(function ($argument): bool {
            return is_array($argument) && $argument[0] instanceof Camt053\DTO\Statement;
        }))->shouldBeCalled();

        $this->decoder->addRecords($message->reveal(), $this->getXmlMessage());
    }

    private function getXmlMessage(): SimpleXMLElement
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

        return new SimpleXMLElement($xmlContent);
    }
}
