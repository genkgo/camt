<?php
namespace Genkgo\Camt\Decoder;

use DateTimeImmutable;

interface DateDecoderInterface
{
    /**
     * @param string $date
     * @return DateTimeImmutable
     */
    public function decode($date);
}
