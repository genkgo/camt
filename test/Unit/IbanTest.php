<?php

declare(strict_types=1);

namespace Genkgo\TestCamt\Unit;

use Genkgo\Camt\Iban;
use InvalidArgumentException;
use PHPUnit\Framework;

class IbanTest extends Framework\TestCase
{
    public function testValidIbanMachineFormat(): void
    {
        $iban = new Iban($expected = 'NL91ABNA0417164300');

        self::assertEquals($expected, $iban->getIban());
        self::assertEquals($expected, $iban);
    }

    public function testValidIbanHumanFormat(): void
    {
        $expected = 'NL91ABNA0417164300';

        $iban = new Iban('IBAN NL91 ABNA 0417 1643 00');

        self::assertEquals($expected, $iban->getIban());
        self::assertEquals($expected, $iban);
    }

    public function testInvalidIban(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Iban('NL91ABNA0417164301');
    }
}
