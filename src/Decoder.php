<?php

declare(strict_types=1);

namespace Genkgo\Camt;

use DOMDocument;
use Genkgo\Camt\DTO\Message;
use Genkgo\Camt\Exception\InvalidMessageException;
use SimpleXMLElement;

class Decoder implements DecoderInterface
{
    private SimpleXMLElement $document;

    private Decoder\Message $messageDecoder;

    /**
     * Path to the schema definition.
     */
    protected string $schemeDefinitionPath;

    public function __construct(Decoder\Message $messageDecoder, string $schemeDefinitionPath)
    {
        $this->messageDecoder = $messageDecoder;
        $this->schemeDefinitionPath = $schemeDefinitionPath;
    }

    private function validate(DOMDocument $document): void
    {
        libxml_use_internal_errors(true);
        $valid = $document->schemaValidate(dirname(__DIR__) . $this->schemeDefinitionPath);
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

    public function decode(DOMDocument $document, bool $xsdValidation = true): Message
    {
        if ($xsdValidation === true) {
            $this->validate($document);
        }

        $document = simplexml_import_dom($document);
        if (!$document) {
            throw new InvalidMessageException('Provided XML could not be parsed');
        }

        $this->document = $document;

        $message = new DTO\Message();
        $this->messageDecoder->addGroupHeader($message, $this->document);
        $this->messageDecoder->addRecords($message, $this->document);

        return $message;
    }
}
