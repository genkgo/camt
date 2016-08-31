<?php
namespace Genkgo\Camt\Unit\Util;

use Genkgo\Camt\AbstractTestCase;
use Genkgo\Camt\Util\StringToUnits;

class StringToUnitsTest extends AbstractTestCase
{
    public function testOneDecimals()
    {
        $this->assertEquals('1810', StringToUnits::convert('18.1'));
    }

    public function testTwoDecimals()
    {
        $this->assertEquals('1815', StringToUnits::convert('18.15'));
    }

    public function testThreeDecimals()
    {
        $this->assertEquals('1815', StringToUnits::convert('18.150'));
    }

    public function testFourDecimals()
    {
        $this->assertEquals('1815', StringToUnits::convert('18.1500'));
    }

    public function testFiveDecimals()
    {
        $this->assertEquals('1815', StringToUnits::convert('18.15000'));
    }
}
