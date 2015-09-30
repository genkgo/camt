<?php
namespace Genkgo\Camt;

use DOMDocument;
use Genkgo\Camt\Camt053\Message;

interface DecoderInterface
{
    /**
     * @param DOMDocument $document
     * @return mixed|Message
     */
    public function decode(DOMDocument $document);
}
