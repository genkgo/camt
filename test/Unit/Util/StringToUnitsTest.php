<?php

declare(strict_types=1);

namespace Genkgo\TestCamt\Unit\Util;

use Genkgo\Camt\Util\StringToUnits;
use Genkgo\TestCamt\AbstractTestCase;

class StringToUnitsTest extends AbstractTestCase
{
    public function testOneDecimals(): void
    {
        self::assertEquals('1810', StringToUnits::convert('18.1'));
    }

    public function testTwoDecimals(): void
    {
        self::assertEquals('1815', StringToUnits::convert('18.15'));
    }

    public function testThreeDecimals(): void
    {
        self::assertEquals('1815', StringToUnits::convert('18.150'));
    }

    public function testFourDecimals(): void
    {
        self::assertEquals('1815', StringToUnits::convert('18.1500'));
    }

    public function testFiveDecimals(): void
    {
        self::assertEquals('1815', StringToUnits::convert('18.15000'));
    }
}
