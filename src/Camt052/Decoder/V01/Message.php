<?php

namespace Genkgo\Camt\Camt052\Decoder\V01;

use Genkgo\Camt\Camt052\Decoder\Message as BaseMessageDecoder;
use \SimpleXMLElement;

class Message extends BaseMessageDecoder
{
    /**
     * {@inheritdoc}
     */
    public function getRootElement(SimpleXMLElement $document)
    {
        return $document->BkToCstmrAcctRptV01;
    }
}
