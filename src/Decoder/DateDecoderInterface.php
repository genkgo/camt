<?php

declare(strict_types=1);

namespace Genkgo\Camt\Decoder;

use DateTimeImmutable;
use SimpleXMLElement;

interface DateDecoderInterface
{
    public function decode(string $date): DateTimeImmutable;

    public function fromDateAndDateTimeChoice(SimpleXMLElement $xmlEntry): DateTimeImmutable;
}
