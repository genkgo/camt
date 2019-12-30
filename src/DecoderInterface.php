<?php

declare(strict_types=1);
namespace Genkgo\Camt;

use DOMDocument;
use Genkgo\Camt\DTO\Message;

interface DecoderInterface
{
    /**
     * @param DOMDocument $document
     * @param bool $xsdValidation
     *
     * @return Message
     */
    public function decode(DOMDocument $document, bool $xsdValidation = true): Message;
}
