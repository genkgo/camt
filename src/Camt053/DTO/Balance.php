<?php

namespace Genkgo\Camt\Camt053\DTO;

use DateTimeImmutable;
use Money\Money;

/**
 * Class Balance
 * @package Genkgo\Camt\Camt053
 */
class Balance
{
    /**
     *
     */
    const TYPE_OPENING = 'opening';
    /**
     *
     */
    const TYPE_CLOSING = 'closing';

    /**
     * @var Money
     */
    private $amount;
    /**
     * @var string
     */
    private $type;

    /**
     * @var DateTimeImmutable
     */
    private $date;

    /**
     * @param $type
     * @param Money $amount
     * @param DateTimeImmutable $date
     */
    private function __construct($type, Money $amount, DateTimeImmutable $date)
    {
        $this->type = $type;
        $this->amount = $amount;
        $this->date = $date;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return Money
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param Money $amount
     * @param DateTimeImmutable $date
     * @return static
     */
    public static function opening(Money $amount, DateTimeImmutable $date)
    {
        return new static (self::TYPE_OPENING, $amount, $date);
    }

    /**
     * @param Money $amount
     * @param DateTimeImmutable $date
     * @return static
     */
    public static function closing(Money $amount, DateTimeImmutable $date)
    {
        return new static (self::TYPE_CLOSING, $amount, $date);
    }
}
