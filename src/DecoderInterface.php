<?php
namespace Genkgo\Camt;

use DOMDocument;

interface DecoderInterface
{
    /**
     * @param DOMDocument $document
     * @return mixed
     */
    public function decode(DOMDocument $document);
}
