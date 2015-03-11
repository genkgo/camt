<?php
namespace Genkgo\Camt\Unit;

use DOMDocument;
use Genkgo\Camt\AbstractTestCase;
use Genkgo\Camt\Camt053\Message;
use Genkgo\Camt\Config;
use Genkgo\Camt\Exception\ReaderException;
use Genkgo\Camt\Reader;

class ReaderTest extends AbstractTestCase {

    protected function getDefaultConfig () {
        $config = new Config();
        $config->addMessageFormat(new \Genkgo\Camt\Camt053\MessageFormat());
        return $config;
    }

    public function testReadEmptyDocument () {
        $this->setExpectedException(ReaderException::class);
        $reader = new Reader($this->getDefaultConfig());
        $reader->readDom(new DOMDocument('1.0', 'UTF-8'));
    }

    public function testConstructorWrongFormat () {
        $this->setExpectedException(ReaderException::class);

        $dom = new DOMDocument('1.0', 'UTF-8');
        $root = $dom->createElement('Document');
        $root->setAttribute('xmlns', 'unknown');
        $dom->appendChild($root);

        $reader = new Reader($this->getDefaultConfig());
        $reader->readDom($dom);
    }

    public function testConstructor () {
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->load(__DIR__.'/Camt053/Stubs/camt053.minimal.xml');

        $reader = new Reader($this->getDefaultConfig());
        $this->assertInstanceOf(Message::class, $reader->readDom($dom));
    }

}