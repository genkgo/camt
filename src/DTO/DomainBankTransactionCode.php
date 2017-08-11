<?php
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
    public function __construct($code)
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return DomainFamilyBankTransactionCode
     */
    public function getFamily()
    {
        return $this->family;
    }

    /**
     * @param DomainFamilyBankTransactionCode $family
     */
    public function setFamily(DomainFamilyBankTransactionCode $family)
    {
        $this->family = $family;
    }
}
