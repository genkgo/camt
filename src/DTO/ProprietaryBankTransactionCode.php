<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

class ProprietaryBankTransactionCode
{
    private string $code;

    private string $issuer;

    public function __construct(string $code, string $issuer)
    {
        $this->code = $code;
        $this->issuer = $issuer;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    public function getIssuer(): string
    {
        return $this->issuer;
    }

    public function setIssuer(string $issuer): void
    {
        $this->issuer = $issuer;
    }
}
