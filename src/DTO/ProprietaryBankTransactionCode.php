<?php

declare(strict_types=1);
namespace Genkgo\Camt\DTO;

class ProprietaryBankTransactionCode
{
    /** @var string */
    private $code;

    /** @var string */
    private $issuer;

    /**
     * @param string $code
     * @param string $issuer
     */
    public function __construct(string $code, string $issuer)
    {
        $this->code = $code;
        $this->issuer = $issuer;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getIssuer(): string
    {
        return $this->issuer;
    }

    /**
     * @param string $issuer
     */
    public function setIssuer(string $issuer): void
    {
        $this->issuer = $issuer;
    }
}
