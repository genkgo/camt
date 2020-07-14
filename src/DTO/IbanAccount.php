<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

use Genkgo\Camt\Iban;

class IbanAccount extends Account
{
    /**
     * @var Iban
     */
    private $iban;

    public function __construct(Iban $iban)
    {
        $this->iban = $iban;
    }

    public function getIban(): Iban
    {
        return $this->iban;
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentification(): string
    {
        return (string) $this->iban;
    }
}
