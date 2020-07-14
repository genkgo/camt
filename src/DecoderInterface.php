<?php

declare(strict_types=1);

namespace Genkgo\Camt;

use DOMDocument;
use Genkgo\Camt\DTO\Message;

interface DecoderInterface
{
    public function decode(DOMDocument $document, bool $xsdValidation = true): Message;
}
