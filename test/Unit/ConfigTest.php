<?php

namespace Genkgo\TestCamt\Unit;

use Genkgo\Camt\Config;
use PHPUnit\Framework\TestCase;

/**
 * @group config
 */
class ConfigTest extends TestCase
{
    public function testDefaultConfigHasXsdValidation()
    {
        $config = Config::getDefault();

        $this->assertTrue($config->getXsdValidation());
    }

    public function testNoValidateConfigHasNoXsdValidation()
    {
        $config = Config::getDefault();
        $config->disableXsdValidation();

        $this->assertFalse($config->getXsdValidation());
    }
}
