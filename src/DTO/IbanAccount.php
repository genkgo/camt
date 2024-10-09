<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

use Genkgo\Camt\Iban;

class IbanAccount extends Account
{
    private Iban $iban;

    public function __construct(Iban $iban)
    {
        $this->iban = $iban;
    }

    public function getIban(): Iban
    {
        return $this->iban;
    }

    /**
     * @inheritDoc
     */
    public function getIdentification(): string
    {
        return (string) $this->iban;
    }
}
