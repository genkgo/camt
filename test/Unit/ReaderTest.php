<?php

declare(strict_types=1);

namespace Genkgo\TestCamt\Unit;

use DOMDocument;
use Genkgo\Camt\Camt053\MessageFormat;
use Genkgo\Camt\Config;
use Genkgo\Camt\DTO;
use Genkgo\Camt\Exception\ReaderException;
use Genkgo\Camt\Reader;
use Genkgo\TestCamt\AbstractTestCase;

class ReaderTest extends AbstractTestCase
{
    protected function getDefaultConfig(): Config
    {
        $config = new Config();
        $config->addMessageFormat(new MessageFormat\V02());

        return $config;
    }

    public function testReadEmptyDocument(): void
    {
        $this->expectException(ReaderException::class);
        $reader = new Reader($this->getDefaultConfig());
        $reader->readDom(new DOMDocument('1.0', 'UTF-8'));
    }

    public function testReadWrongFormat(): void
    {
        $this->expectException(ReaderException::class);

        $dom = new DOMDocument('1.0', 'UTF-8');
        $root = $dom->createElement('Document');
        $root->setAttribute('xmlns', 'unknown');
        $dom->appendChild($root);

        $reader = new Reader($this->getDefaultConfig());
        $reader->readDom($dom);
    }

    public function testReadFile(): void
    {
        $reader = new Reader(Config::getDefault());
        $message = $reader->readFile(__DIR__ . '/Camt053/Stubs/camt053.v2.minimal.xml');
        self::assertInstanceOf(DTO\Message::class, $message);
    }

    public function testReadFileWithNoXsdValidation(): void
    {
        $config = Config::getDefault();
        $config->disableXsdValidation();

        $reader = new Reader($config);
        $message = $reader->readFile(__DIR__ . '/Camt053/Stubs/camt053.v2.minimal.xml');
        self::assertInstanceOf(DTO\Message::class, $message);
    }
}
