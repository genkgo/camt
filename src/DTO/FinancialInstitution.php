<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

class FinancialInstitution
{
    public function __construct(
        private readonly ?string $bic,
        private readonly ?string $name,
    ) {
    }

    public function getBic(): ?string
    {
        return $this->bic;
    }

    public function getName(): ?string
    {
        return $this->name;
    }
}
