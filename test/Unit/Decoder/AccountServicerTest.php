<?php

declare(strict_types=1);

namespace Genkgo\TestCamt\Unit\Decoder;

use Genkgo\Camt\Decoder\Message as BaseMessageDecoder;
use Genkgo\Camt\DTO;
use PHPUnit\Framework;
use ReflectionMethod;
use SimpleXMLElement;

class AccountServicerTest extends Framework\TestCase
{
    private BaseMessageDecoder $decoder;

    private ReflectionMethod $method;

    protected function setUp(): void
    {
        $this->decoder = new class($this->createMock(\Genkgo\Camt\Decoder\Record::class), new \Genkgo\Camt\Decoder\Date()) extends BaseMessageDecoder {
            public function addRecords(DTO\Message $message, SimpleXMLElement $document): void
            {
            }

            public function getRootElement(SimpleXMLElement $document): SimpleXMLElement
            {
                return $document;
            }
        };

        $this->method = new ReflectionMethod(BaseMessageDecoder::class, 'getAccountServicer');
        $this->method->setAccessible(true);
    }

    public function testItReturnsNullWhenNoServicer(): void
    {
        $xml = new SimpleXMLElement('<Acct><Id><IBAN>DE89370400440532013000</IBAN></Id></Acct>');

        self::assertNull($this->method->invoke($this->decoder, $xml));
    }

    public function testItExtractsBicFromBicTag(): void
    {
        $xml = new SimpleXMLElement('<Acct><Svcr><FinInstnId><BIC>COBADEFFXXX</BIC><Nm>Commerzbank AG</Nm></FinInstnId></Svcr></Acct>');

        $servicer = $this->method->invoke($this->decoder, $xml);

        self::assertInstanceOf(DTO\FinancialInstitution::class, $servicer);
        self::assertSame('COBADEFFXXX', $servicer->getBic());
        self::assertSame('Commerzbank AG', $servicer->getName());
    }

    public function testItExtractsBicFromBicfiTag(): void
    {
        $xml = new SimpleXMLElement('<Acct><Svcr><FinInstnId><BICFI>UBSWCHZH80A</BICFI><Nm>UBS SWITZERLAND AG</Nm></FinInstnId></Svcr></Acct>');

        $servicer = $this->method->invoke($this->decoder, $xml);

        self::assertInstanceOf(DTO\FinancialInstitution::class, $servicer);
        self::assertSame('UBSWCHZH80A', $servicer->getBic());
        self::assertSame('UBS SWITZERLAND AG', $servicer->getName());
    }

    public function testItReturnsNameOnlyWhenNoBic(): void
    {
        $xml = new SimpleXMLElement('<Acct><Svcr><FinInstnId><Nm>AAAA BANKEN</Nm></FinInstnId></Svcr></Acct>');

        $servicer = $this->method->invoke($this->decoder, $xml);

        self::assertInstanceOf(DTO\FinancialInstitution::class, $servicer);
        self::assertNull($servicer->getBic());
        self::assertSame('AAAA BANKEN', $servicer->getName());
    }

    public function testItReturnsNullWhenFinInstnIdIsEmpty(): void
    {
        $xml = new SimpleXMLElement('<Acct><Svcr><FinInstnId></FinInstnId></Svcr></Acct>');

        self::assertNull($this->method->invoke($this->decoder, $xml));
    }
}
