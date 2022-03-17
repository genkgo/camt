<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

use DateTimeImmutable;
use Money\Money;

class Balance
{
    public const TYPE_OPENING = 'opening';

    public const TYPE_OPENING_AVAILABLE = 'opening_available';

    public const TYPE_CLOSING = 'closing';

    public const TYPE_CLOSING_AVAILABLE = 'closing_available';

    private Money $amount;

    private string $type;

    private DateTimeImmutable $date;

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

    public static function openingAvailable(Money $amount, DateTimeImmutable $date): self
    {
        return new self(self::TYPE_OPENING_AVAILABLE, $amount, $date);
    }

    public static function closing(Money $amount, DateTimeImmutable $date): self
    {
        return new self(self::TYPE_CLOSING, $amount, $date);
    }

    public static function closingAvailable(Money $amount, DateTimeImmutable $date): self
    {
        return new self(self::TYPE_CLOSING_AVAILABLE, $amount, $date);
    }
}
