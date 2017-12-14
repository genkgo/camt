<?php
namespace Genkgo\Camt;

use DOMDocument;
use Genkgo\Camt\DTO\Message;

interface DecoderInterface
{
    /**
     * @param DOMDocument $document
     * @return mixed|Message
     */
    public function decode(DOMDocument $document, $xsdValidation = true);
}
