<?php
namespace Genkgo\Camt;

use DOMDocument;
use Genkgo\Camt\Exception\ReaderException;

class Reader {

    private $config;

    public function __construct (Config $config) {
        $this->config = $config;
    }

    public function readDom (DOMDocument $document) {
        if ($document->documentElement === null) {
            throw new ReaderException("Empty document");
        }

        $xmlNs = $document->documentElement->getAttribute('xmlns');
        $messageFormat = $this->getMessageFormatForXmlNs($xmlNs);
        return $messageFormat->getMessage($document);
    }

    public function readString ($string) {
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->loadXML($string);
        return $this->readDom($dom);
    }

    public function readFile ($file) {
        if (!file_exists($file)) {
            throw new ReaderException("{$file} does not exists");
        }

        return $this->readString(file_get_contents($file));
    }

    private function getMessageFormatForXmlNs ($xmlNs) {
        $messageFormats = $this->config->getMessageFormats();
        foreach ($messageFormats as $messageFormat) {
            if ($messageFormat->getXmlNs() === $xmlNs) {
                return $messageFormat;
            }
        }

        throw new ReaderException("Unsupported format, cannot find message format with xmlns {$xmlNs}");
    }

}