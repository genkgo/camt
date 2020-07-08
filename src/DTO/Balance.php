<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

use DateTimeImmutable;
use Money\Money;

class Balance
{
    const TYPE_OPENING = 'opening';

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

    private function __construct(string $type, Money $amount, DateTimeImmutable $date)
    {
        $this->type = $type;
        $this->amount = $amount;
        $this->date = $date;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    public function getAmount(): Money
    {
        return $this->amount;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public static function opening(Money $amount, DateTimeImmutable $date): self
    {
        return new self(self::TYPE_OPENING, $amount, $date);
    }

    public static function closing(Money $amount, DateTimeImmutable $date): self
    {
        return new self(self::TYPE_CLOSING, $amount, $date);
    }
}
