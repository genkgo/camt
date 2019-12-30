<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

class AdditionalTransactionInformation
{
    private $information;

    public function __construct($information)
    {
        $this->information = $information;
    }

    public function __toString(): string
    {
        return (string) $this->information;
    }
}
