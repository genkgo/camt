<?php

declare(strict_types=1);
namespace Genkgo\Camt\Decoder;

use DateTimeImmutable;

interface DateDecoderInterface
{
    /**
     * @param string $date
     * @return DateTimeImmutable
     */
    public function decode(string $date): DateTimeImmutable;
}
