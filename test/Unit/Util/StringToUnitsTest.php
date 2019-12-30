<?php

declare(strict_types=1);
namespace Genkgo\TestCamt\Unit\Util;

use Genkgo\TestCamt\AbstractTestCase;
use Genkgo\Camt\Util\StringToUnits;

class StringToUnitsTest extends AbstractTestCase
{
    public function testOneDecimals(): void
    {
        $this->assertEquals('1810', StringToUnits::convert('18.1'));
    }

    public function testTwoDecimals(): void
    {
        $this->assertEquals('1815', StringToUnits::convert('18.15'));
    }

    public function testThreeDecimals(): void
    {
        $this->assertEquals('1815', StringToUnits::convert('18.150'));
    }

    public function testFourDecimals(): void
    {
        $this->assertEquals('1815', StringToUnits::convert('18.1500'));
    }

    public function testFiveDecimals(): void
    {
        $this->assertEquals('1815', StringToUnits::convert('18.15000'));
    }
}
