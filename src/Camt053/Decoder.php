<?php
namespace Genkgo\Camt\Camt053;

use DateTimeImmutable;
use DOMDocument;
use Genkgo\Camt\DecoderInterface;
use Genkgo\Camt\Exception\InvalidMessageException;
use Genkgo\Camt\Util\StringToUnits;
use Money\Currency;
use Money\Money;
use SimpleXMLElement;

class Decoder implements DecoderInterface
{
    /**
     * @var SimpleXMLElement[]
     */
    private $document;

    /**
     * @var Decoder\Message
     */
    private $messageDecoder;

    /**
     * Path to the schema definition
     * @var string
     */
    protected $schemeDefinitionPath;

    /**
     * @param Decoder\Message $messageDecoder
     * @param string          $schemeDefinitionPath
     */
    public function __construct(Decoder\Message $messageDecoder, $schemeDefinitionPath)
    {
        $this->messageDecoder       = $messageDecoder;
        $this->schemeDefinitionPath = $schemeDefinitionPath;
    }

    /**
     * @param DOMDocument $document
     * @throws InvalidMessageException
     */
    private function validate(DOMDocument $document)
    {
        libxml_use_internal_errors(true);
        $valid = $document->schemaValidate(dirname(dirname(__DIR__)).$this->schemeDefinitionPath);
        $errors = libxml_get_errors();
        libxml_clear_errors();

        if (!$valid) {
            $messages = [];
            foreach ($errors as $error) {
                $messages[] = $error->message;
            }

            $errorMessage = implode("\n", $messages);
            throw new InvalidMessageException("Provided XML is not valid according to the XSD:\n{$errorMessage}");
        }
    }

    /**
     * @param DOMDocument $document
     * @return Message
     * @throws InvalidMessageException
     */
    public function decode(DOMDocument $document)
    {
        $this->validate($document);
        $this->document = simplexml_import_dom($document);

        $message = new DTO\Message();
        $this->messageDecoder->addGroupHeader($message, $this->document);
        $this->messageDecoder->addStatements($message, $this->document);

        return $message;
    }
}
