<?php
namespace Genkgo\Camt\DTO;

class DomainFamilyBankTransactionCode
{
    /** @var string */
    private $code;

    /** @var string */
    private $subFamilyCode;

    /**
     * @param string $code
     * @param string $subFamilyCode
     */
    public function __construct(string $code, string $subFamilyCode)
    {
        $this->code = $code;
        $this->subFamilyCode = $subFamilyCode;
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
    public function getSubFamilyCode(): string
    {
        return $this->subFamilyCode;
    }

    /**
     * @param string $issuer
     */
    public function setSubFamilyCode(string $issuer): void
    {
        $this->subFamilyCode = $issuer;
    }
}
