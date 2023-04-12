<?php

declare(strict_types=1);

namespace Genkgo\TestCamt\Unit;

use Genkgo\Camt\Config;
use Genkgo\Camt\Reader;
use PHPUnit\Framework\Assert;
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
    public function testRegression(string $file): void
    {
        $reader = new Reader(Config::getDefault());
        $message = $reader->readFile($file);

        $dumper = new Dumper();
        $actual = $dumper->dump($message);
        $expectedFile = str_replace('.xml', '.json', $file);

        $this->assertFile($expectedFile, $actual);
    }

    /**
     * Custom assert that will not produce gigantic diff.
     */
    private function assertFile(string $file, string $actualContent): void
    {
        // Log actual result for easier comparison with external diff tools
        $logFile = 'logs/' . $file;
        $dir = dirname($logFile);
        @mkdir($dir, 0777, true);
        file_put_contents($logFile, $actualContent);

        Assert::assertFileExists($file, 'Expected file must exist on disk, fix it with: cp ' . $logFile . ' ' . $file);
        $expected = file_get_contents($file);

        Assert::assertTrue($expected === $actualContent, 'File content does not match, compare with: meld ' . $file . ' ' . $logFile);
    }

    public static function providerRegression(): iterable
    {
        yield ['test/data/camt052.v1.xml'];
        yield ['test/data/camt052.v2.other-account.xml'];
        yield ['test/data/camt052.v2.xml'];
        yield ['test/data/camt052.v4.xml'];
        yield ['test/data/camt052.v6.xml'];
        yield ['test/data/camt052.v8.xml'];
        yield ['test/data/camt053.v2.five.decimals.xml'];
        yield ['test/data/camt053.v2.minimal.ultimate.xml'];
        yield ['test/data/camt053.v2.minimal.xml'];
        yield ['test/data/camt053.v2.multi.statement.xml'];
        yield ['test/data/camt053.v3.xml'];
        yield ['test/data/camt053.v4.xml'];
        yield ['test/data/camt053.v8.xml'];
        yield ['test/data/camt054.v2.xml'];
        yield ['test/data/camt054.v4.xml'];
        yield ['test/data/camt054.v8-with-UETR.xml'];
        yield ['test/data/camt054.v8-with-financial-institution.xml'];
        yield ['test/data/camt054.v8.xml'];
    }
}
