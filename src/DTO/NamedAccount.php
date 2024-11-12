<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

use Genkgo\Camt\Iban;

class NamedAccount extends Account
{
    private Iban $iban;

    private string $name;

    public function __construct(Iban $iban, string $name)
    {
        $this->iban = $iban;
        $this->name = $name;
    }

    public function getIban(): Iban
    {
        return $this->iban;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function getIdentification(): string
    {
        return (string) $this->iban;
    }
}
