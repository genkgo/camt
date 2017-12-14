<?php

namespace Genkgo\TestCamt\Unit;

use DOMDocument;
use Genkgo\TestCamt\AbstractTestCase;
use Genkgo\Camt\DTO;
use Genkgo\Camt\Camt053\MessageFormat;
use Genkgo\Camt\Config;
use Genkgo\Camt\Exception\ReaderException;
use Genkgo\Camt\Reader;

class ReaderTest extends AbstractTestCase
{
    protected function getDefaultConfig()
    {
        $config = new Config();
        $config->addMessageFormat(new MessageFormat\V02());

        return $config;
    }

    public function testReadEmptyDocument()
    {
        $this->expectException(ReaderException::class);
        $reader = new Reader($this->getDefaultConfig());
        $reader->readDom(new DOMDocument('1.0', 'UTF-8'));
    }

    public function testReadWrongFormat()
    {
        $this->expectException(ReaderException::class);

        $dom = new DOMDocument('1.0', 'UTF-8');
        $root = $dom->createElement('Document');
        $root->setAttribute('xmlns', 'unknown');
        $dom->appendChild($root);

        $reader = new Reader($this->getDefaultConfig());
        $reader->readDom($dom);
    }

    public function testReadFile()
    {
        $reader = new Reader(Config::getDefault());
        $message = $reader->readFile(__DIR__.'/Camt053/Stubs/camt053.v2.minimal.xml');
        $this->assertInstanceOf(DTO\Message::class, $message);
    }


    public function testReadFileWithNoXsdValidation()
    {
        $config = Config::getDefault();
        $config->disableXsdValidation();

        $reader = new Reader($config);
        $message = $reader->readFile(__DIR__.'/Camt053/Stubs/camt053.v2.minimal.xml');
        $this->assertInstanceOf(DTO\Message::class, $message);
    }
}
