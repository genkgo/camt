<?php

declare(strict_types=1);

namespace Genkgo\Camt\Decoder;

use DateTimeImmutable;

interface DateDecoderInterface
{
    public function decode(string $date): DateTimeImmutable;
}
