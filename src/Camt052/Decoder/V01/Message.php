<?php

namespace Genkgo\Camt\Camt052\Decoder\V01;

use Genkgo\Camt\Camt052\Decoder\Message as BaseMessageDecoder;
use Genkgo\Camt\Camt052\DTO as Camt052DTO;
use Genkgo\Camt\DTO;
use \SimpleXMLElement;
use \DateTimeImmutable;

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
