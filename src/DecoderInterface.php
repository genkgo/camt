<?php
namespace Genkgo\Camt;

use DOMDocument;
use Genkgo\Camt\DTO\Message;

interface DecoderInterface
{
    /**
     * @param DOMDocument $document
     * @param bool $xsdValidation
     *
     * @return Message|mixed
     */
    public function decode(DOMDocument $document, bool $xsdValidation = true);
}
