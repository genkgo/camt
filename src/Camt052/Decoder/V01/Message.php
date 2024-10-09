<?php

declare(strict_types=1);

namespace Genkgo\Camt\Camt052\Decoder\V01;

use Genkgo\Camt\Camt052\Decoder\Message as BaseMessageDecoder;
use SimpleXMLElement;

class Message extends BaseMessageDecoder
{
    /**
     * @inheritDoc
     */
    public function getRootElement(SimpleXMLElement $document): SimpleXMLElement
    {
        return $document->BkToCstmrAcctRptV01;
    }
}
