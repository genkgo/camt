<?php

declare(strict_types=1);

namespace Genkgo\TestCamt\Unit\Camt052\Decoder;

use Genkgo\Camt\Camt052;
use Genkgo\Camt\Camt052\Decoder\V01\Message;
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

    public function testItAddsReports(): void
    {
        $message = $this->createMock(DTO\Message::class);

        $this->mockedRecordDecoder
            ->expects(self::once())
            ->method('addBalances')
            ->with(
                self::isInstanceOf(Camt052\DTO\Report::class),
                self::isInstanceOf(SimpleXMLElement::class)
            );

        $this->mockedRecordDecoder
            ->expects(self::once())
            ->method('addEntries')
            ->with(
                self::isInstanceOf(Camt052\DTO\Report::class),
                self::isInstanceOf(SimpleXMLElement::class)
            );

        $message
            ->expects(self::once())
            ->method('setRecords')
            ->with(self::callback(static function (array $records): bool {
                self::assertContainsOnlyInstancesOf(Camt052\DTO\Report::class, $records);
                self::assertCount(1, $records);

                return true;
            }));

        $this->decoder->addRecords($message, $this->getXmlMessage());
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
