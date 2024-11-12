<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

use Genkgo\Camt\Iban;

class IbanAccount extends Account
{
    public function __construct(
        private readonly Iban $iban,
        private readonly ?string $name,
    ) {
    }

    public function getIban(): Iban
    {
        return $this->iban;
    }

    public function getName(): ?string
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
