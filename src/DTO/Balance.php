<?php

namespace Genkgo\Camt\DTO;

use DateTimeImmutable;
use Money\Money;

/**
 * Class Balance
 * @package Genkgo\Camt\DTO
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
     * @param string $type
     * @param Money $amount
     * @param DateTimeImmutable $date
     */
    private function __construct(string $type, Money $amount, DateTimeImmutable $date)
    {
        $this->type = $type;
        $this->amount = $amount;
        $this->date = $date;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    /**
     * @return Money
     */
    public function getAmount(): Money
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param Money $amount
     * @param DateTimeImmutable $date
     * @return self
     */
    public static function opening(Money $amount, DateTimeImmutable $date): Balance
    {
        return new self(self::TYPE_OPENING, $amount, $date);
    }

    /**
     * @param Money $amount
     * @param DateTimeImmutable $date
     * @return self
     */
    public static function closing(Money $amount, DateTimeImmutable $date): Balance
    {
        return new self(self::TYPE_CLOSING, $amount, $date);
    }
}
