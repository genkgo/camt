<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

abstract class Account
{
    private ?FinancialInstitution $servicer = null;

    abstract public function getIdentification(): string;

    public function getServicer(): ?FinancialInstitution
    {
        return $this->servicer;
    }

    public function setServicer(?FinancialInstitution $servicer): void
    {
        $this->servicer = $servicer;
    }
}
