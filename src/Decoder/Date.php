<?php
namespace Genkgo\Camt\Decoder;

class Date implements DateDecoderInterface
{
    /**
     * @var
     */
    private $format;

    /**
     * @param $date
     * @return \DateTimeImmutable
     */
    public function decode($date)
    {
        if ($this->format === null) {
            $result = new \DateTimeImmutable($date);
        } else {
            $result = \DateTimeImmutable::createFromFormat($this->format, $date);
        }

        if ($result === false) {
            throw new \InvalidArgumentException("Cannot decode date {$date}");
        }

        return $result;
    }

    /**
     * @param $format
     * @return Date
     */
    public static function fromFormat($format)
    {
        $decoder = new self();
        $decoder->format = $format;
        return $decoder;
    }
}
