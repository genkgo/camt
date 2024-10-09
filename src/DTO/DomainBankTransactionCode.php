<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

class DomainBankTransactionCode
{
    private string $code;

    private DomainFamilyBankTransactionCode $family;

    public function __construct(string $code)
    {
        $this->code = $code;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    public function getFamily(): DomainFamilyBankTransactionCode
    {
        return $this->family;
    }

    public function setFamily(DomainFamilyBankTransactionCode $family): void
    {
        $this->family = $family;
    }
}
