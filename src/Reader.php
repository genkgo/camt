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
     * @var null|MessageFormatInterface
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

        return $this->messageFormat->getDecoder()->decode($document, $this->config->getXsdValidation());
    }

    /**
     * @param string $string
     * @return mixed
     * @throws ReaderException
     */
    public function readString($string)
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->loadXML($string);

        return $this->readDom($dom);
    }

    /**
     * @param  string $file
     * @return Message|mixed
     * @throws ReaderException
     */
    public function readFile($file)
    {
        if (!file_exists($file)) {
            throw new ReaderException("{$file} does not exists");
        }

        $string = file_get_contents($file);
        if ($string === false) {
            throw new ReaderException("Could not read file {$file}");
        }

        return $this->readString($string);
    }

    /**
     * @param string $xmlNs
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
     * @return null|MessageFormatInterface
     */
    public function getMessageFormat()
    {
        return $this->messageFormat;
    }
}
