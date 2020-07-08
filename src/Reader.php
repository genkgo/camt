<?php

declare(strict_types=1);

namespace Genkgo\Camt;

use DOMDocument;
use Genkgo\Camt\DTO\Message;
use Genkgo\Camt\Exception\ReaderException;

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

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @return mixed
     */
    public function readDom(DOMDocument $document)
    {
        if ($document->documentElement === null) {
            throw new ReaderException('Empty document');
        }

        $xmlNs = $document->documentElement->getAttribute('xmlns');
        $this->messageFormat = $this->getMessageFormatForXmlNs($xmlNs);

        return $this->messageFormat->getDecoder()->decode($document, $this->config->getXsdValidation());
    }

    /**
     * @return mixed
     */
    public function readString(string $string)
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->loadXML($string);

        return $this->readDom($dom);
    }

    /**
     * @return Message|mixed
     */
    public function readFile(string $file)
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

    private function getMessageFormatForXmlNs(string $xmlNs): MessageFormatInterface
    {
        $messageFormats = $this->config->getMessageFormats();
        foreach ($messageFormats as $messageFormat) {
            if ($messageFormat->getXmlNs() === $xmlNs) {
                return $messageFormat;
            }
        }

        throw new ReaderException("Unsupported format, cannot find message format with xmlns {$xmlNs}");
    }

    public function getMessageFormat(): ?MessageFormatInterface
    {
        return $this->messageFormat;
    }
}
