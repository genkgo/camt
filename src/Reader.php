<?php
namespace Genkgo\Camt;

use DOMDocument;
use Genkgo\Camt\DTO\Message;
use Genkgo\Camt\Exception\ReaderException;

/**
 * Class Reader
 * @package Genkgo\Camt
 */
class Reader
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var MessageFormatInterface
     */
    private $messageFormat;

    /**
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @param DOMDocument $document
     * @return mixed
     * @throws ReaderException
     */
    public function readDom(DOMDocument $document)
    {
        if ($document->documentElement === null) {
            throw new ReaderException("Empty document");
        }

        $xmlNs = $document->documentElement->getAttribute('xmlns');
        $this->messageFormat = $this->getMessageFormatForXmlNs($xmlNs);

        return $this->messageFormat->getDecoder()->decode($document);
    }

    /**
     * @param $string
     * @return mixed
     * @throws ReaderException
     */
    public function readString($string)
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->loadXML($string);

        return $this->readDom($dom);
    }

    public function readDoc($string)
    {
        $string = file_get_contents($string);
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->loadXML($string);

        return $dom;
    }


    /**
     * @param  string $file
     * @return mixed|Message
     * @throws ReaderException
     */
    public function readFile($file)
    {
        if (!file_exists($file)) {
            throw new ReaderException("{$file} does not exists");
        }

        return $this->readString(file_get_contents($file));
    }

    /**
     * @param $xmlNs
     * @return MessageFormatInterface
     * @throws ReaderException
     */
    private function getMessageFormatForXmlNs($xmlNs)
    {
        $messageFormats = $this->config->getMessageFormats();
        foreach ($messageFormats as $messageFormat) {
            if ($messageFormat->getXmlNs() === $xmlNs) {
                return $messageFormat;
            }
        }

        throw new ReaderException("Unsupported format, cannot find message format with xmlns {$xmlNs}");
    }

    /**
     * @return MessageFormatInterface
     */
    public function getMessageFormat()
    {
        return $this->messageFormat;
    }
}
