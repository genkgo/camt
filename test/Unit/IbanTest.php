<?php

namespace Genkgo\TestCamt\Unit;

use InvalidArgumentException;
use Genkgo\TestCamt\AbstractTestCase;
use Genkgo\Camt\Iban;

class IbanTest extends AbstractTestCase
{
    public function testValidIbanMachineFormat()
    {
        $iban = new Iban($expected = "NL91ABNA0417164300");

        $this->assertEquals($expected, $iban->getIban());
        $this->assertEquals($expected, $iban);
    }

    public function testValidIbanHumanFormat()
    {
        $expected = "NL91ABNA0417164300";

        $iban = new Iban("IBAN NL91 ABNA 0417 1643 00");

        $this->assertEquals($expected, $iban->getIban());
        $this->assertEquals($expected, $iban);
    }

    public function testInvalidIban()
    {
        $this->expectException(InvalidArgumentException::class);

        new Iban("NL91ABNA0417164301");
    }
}
