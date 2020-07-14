<?php

declare(strict_types=1);

namespace Genkgo\TestCamt\Unit;

use Genkgo\Camt\Config;
use PHPUnit\Framework\TestCase;

/**
 * @group config
 */
class ConfigTest extends TestCase
{
    public function testDefaultConfigHasXsdValidation(): void
    {
        $config = Config::getDefault();

        self::assertTrue($config->getXsdValidation());
    }

    public function testNoValidateConfigHasNoXsdValidation(): void
    {
        $config = Config::getDefault();
        $config->disableXsdValidation();

        self::assertFalse($config->getXsdValidation());
    }
}
