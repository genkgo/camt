<?php

declare(strict_types=1);

namespace Genkgo\TestCamt\Unit;

use Genkgo\Camt\Camt052;
use Genkgo\Camt\Camt053;
use Genkgo\Camt\Camt054;
use Genkgo\Camt\Config;
use Genkgo\Camt\MessageFormatInterface;
use PHPUnit\Framework\TestCase;

/**
 * @group config
 */
class ConfigTest extends TestCase
{
    public function testDefaultConfigHasMessageFormats(): void
    {
        $config = Config::getDefault();

        $messageFormats = $config->getMessageFormats();

        $expectedMessageFormats = [
            Camt052\MessageFormat\V01::class,
            Camt052\MessageFormat\V02::class,
            Camt052\MessageFormat\V04::class,
            Camt052\MessageFormat\V06::class,
            Camt052\MessageFormat\V08::class,
            Camt053\MessageFormat\V02::class,
            Camt053\MessageFormat\V03::class,
            Camt053\MessageFormat\V04::class,
            Camt053\MessageFormat\V08::class,
            Camt054\MessageFormat\V02::class,
            Camt054\MessageFormat\V04::class,
            Camt054\MessageFormat\V08::class,
        ];

        $actualMessageFormats = array_map(static fn (MessageFormatInterface $messageFormat): string => get_class($messageFormat), $messageFormats);

        $additionalMessageFormats = array_diff(
            $actualMessageFormats,
            $expectedMessageFormats
        );

        self::assertEmpty($additionalMessageFormats, sprintf(
            <<<TXT
Failed asserting that the default configuration does not configure additional message formats.

Did you intend to add the following message formats?

- %s

TXT
            ,
            implode("\n- ", $additionalMessageFormats)
        ));

        $missingMessageFormats = array_diff(
            $expectedMessageFormats,
            $actualMessageFormats
        );

        self::assertEmpty($missingMessageFormats, sprintf(
            <<<TXT
Failed asserting that the default configuration configures all expected formats.

Have you forgotten to add the following message formats?

- %s

TXT
            ,
            implode("\n- ", $missingMessageFormats)
        ));
    }

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
