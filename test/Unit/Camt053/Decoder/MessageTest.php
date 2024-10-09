<?php

declare(strict_types=1);

namespace Genkgo\TestCamt\Unit\Camt053\Decoder;

use Genkgo\Camt\Camt053;
use Genkgo\Camt\Camt053\Decoder\Message;
use Genkgo\Camt\Decoder as DecoderObject;
use Genkgo\Camt\DTO;
use PHPUnit\Framework;
use SimpleXMLElement;

class MessageTest extends Framework\TestCase
{
    /**
     * @var DecoderObject\Record&Framework\MockObject\MockObject
     */
    private $mockedRecordDecoder;

    private Message $decoder;

    protected function setUp(): void
    {
        $this->mockedRecordDecoder = $this->createMock(DecoderObject\Record::class);
        $this->decoder = new Message($this->mockedRecordDecoder, new DecoderObject\Date());
    }

    public function testItAddsGroupHeader(): void
    {
        $message = $this->createMock(DTO\Message::class);

        $message
            ->expects(self::once())
            ->method('setGroupHeader')
            ->with(self::isInstanceOf(DTO\GroupHeader::class));

        $this->decoder->addGroupHeader($message, $this->getXmlMessage());
    }

    public function testItAddsStatements(): void
    {
        $message = $this->createMock(DTO\Message::class);

        $this->mockedRecordDecoder
            ->expects(self::once())
            ->method('addBalances')
            ->with(
                self::isInstanceOf(Camt053\DTO\Statement::class),
                self::isInstanceOf(SimpleXMLElement::class)
            );

        $this->mockedRecordDecoder
            ->expects(self::once())
            ->method('addEntries')
            ->with(
                self::isInstanceOf(Camt053\DTO\Statement::class),
                self::isInstanceOf(SimpleXMLElement::class)
            );

        $message
            ->expects(self::once())
            ->method('setRecords')
            ->with(self::callback(static function (array $records): bool {
                self::assertContainsOnlyInstancesOf(Camt053\DTO\Statement::class, $records);
                self::assertCount(1, $records);

                return true;
            }));

        $this->decoder->addRecords($message, $this->getXmlMessage());
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
