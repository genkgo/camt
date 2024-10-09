<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

class AdditionalTransactionInformation
{
    private string $information;

    public function __construct(string $information)
    {
        $this->information = $information;
    }

    public function __toString(): string
    {
        return $this->information;
    }
}
