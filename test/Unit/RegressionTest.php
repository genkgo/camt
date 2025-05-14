<?php

declare(strict_types=1);

namespace Genkgo\TestCamt\Unit;

use Genkgo\Camt\Config;
use Genkgo\Camt\Reader;
use PHPUnit\Framework\TestCase;

class RegressionTest extends TestCase
{
    private string $timezone;

    protected function setUp(): void
    {
        $this->timezone = date_default_timezone_get();
        date_default_timezone_set('UTC');
    }

    protected function tearDown(): void
    {
        date_default_timezone_set($this->timezone);
    }

    /**
     * @dataProvider providerRegression
     */
    public function testRegression(string $file, string $expectedFile): void
    {
        $reader = new Reader(Config::getDefault());
        $message = $reader->readFile($file);

        $dumper = new Dumper();
        $actual = $dumper->dump($message);

        $this->assertFile($expectedFile, $actual);
    }

    /**
     * Custom assert that will also log entire, actual, content to file.
     */
    private function assertFile(string $file, string $actualContent): void
    {
        // Log actual result for easier comparison with external diff tools
        $logFile = 'logs/' . $file;
        $dir = dirname($logFile);
        @mkdir($dir, 0777, true);
        file_put_contents($logFile, $actualContent);

        self::assertStringEqualsFile($file, $actualContent, 'File content does not match, compare with: meld ' . $file . ' ' . $logFile);
    }

    public static function providerRegression(): iterable
    {
        foreach ((glob('test/data/*.xml') ?: []) as $file) {
            $expectedFile = str_replace('.xml', '.json', $file);
            if (is_file($expectedFile)) {
                yield $file => [$file, $expectedFile];
            }
        }
    }
}
