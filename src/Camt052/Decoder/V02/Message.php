<?php

namespace Genkgo\Camt\Camt052\Decoder\V02;

use Genkgo\Camt\Camt052\Decoder\Message as BaseMessageDecoder;
use \SimpleXMLElement;

class Message extends BaseMessageDecoder
{
    /**
     * {@inheritdoc}
     */
    public function getRootElement(SimpleXMLElement $document)
    {
        return $document->BkToCstmrAcctRpt;
    }
}
