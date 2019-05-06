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
     * @return mixed|Message
     */
    public function decode(DOMDocument $document, $xsdValidation = true);
}
