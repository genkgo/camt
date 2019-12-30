<?php

declare(strict_types=1);
namespace Genkgo\Camt\DTO;

class DomainBankTransactionCode
{
    /** @var string */
    private $code;

    /** @var DomainFamilyBankTransactionCode */
    private $family;

    /**
     * @param string $code
     */
    public function __construct(string $code)
    {
        $this->code = $code;
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
     * @return DomainFamilyBankTransactionCode
     */
    public function getFamily(): DomainFamilyBankTransactionCode
    {
        return $this->family;
    }

    /**
     * @param DomainFamilyBankTransactionCode $family
     */
    public function setFamily(DomainFamilyBankTransactionCode $family): void
    {
        $this->family = $family;
    }
}
