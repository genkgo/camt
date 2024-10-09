<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

class DomainFamilyBankTransactionCode
{
    private string $code;

    private string $subFamilyCode;

    public function __construct(string $code, string $subFamilyCode)
    {
        $this->code = $code;
        $this->subFamilyCode = $subFamilyCode;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    public function getSubFamilyCode(): string
    {
        return $this->subFamilyCode;
    }

    public function setSubFamilyCode(string $issuer): void
    {
        $this->subFamilyCode = $issuer;
    }
}
