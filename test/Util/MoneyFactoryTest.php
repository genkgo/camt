<?php

declare(strict_types=1);

namespace Genkgo\TestCamt\Util;

use Genkgo\Camt\Util\MoneyFactory;
use Money\Money;
use PHPUnit\Framework\TestCase;
use SimpleXMLElement;

class MoneyFactoryTest extends TestCase
{
    /**
     * @dataProvider providerCreate
     */
    public function testCreate(string $amount, ?string $CdtDbtInd, Money $expected): void
    {
        $factory = new MoneyFactory();

        $xmlAmount = new SimpleXMLElement($amount);
        $xmlCdtDbtInd = $CdtDbtInd ? new SimpleXMLElement($CdtDbtInd) : null;
        $actual = $factory->create($xmlAmount, $xmlCdtDbtInd);

        self::assertTrue($actual->equals($expected));
    }

    public function providerCreate(): array
    {
        return [
            ['<Amt Ccy="CHF">27.50</Amt>', null, Money::CHF(2750)],
            ['<Amt Ccy="CHF">27.50</Amt>', '<CdtDbtInd>DBIT</CdtDbtInd>', Money::CHF(-2750)],
            ['<Amt Ccy="CHF">27.50</Amt>', '<CdtDbtInd>CRDT</CdtDbtInd>', Money::CHF(2750)],
            ['<Amt Ccy="JPY">27</Amt>', null, Money::JPY(27)],
            ['<Amt Ccy="JPY">27</Amt>', '<CdtDbtInd>DBIT</CdtDbtInd>', Money::JPY(-27)],
            ['<Amt Ccy="JPY">27</Amt>', '<CdtDbtInd>CRDT</CdtDbtInd>', Money::JPY(27)],
        ];
    }
}
