<?php
namespace Genkgo\Camt\Decoder;

interface DateDecoderInterface
{
    /**
     * @param string $date
     * @return \DateTimeImmutable
     */
    public function decode($date);
}
