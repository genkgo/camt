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
    public function __construct($code, $subFamilyCode)
    {
        $this->code = $code;
        $this->subFamilyCode = $subFamilyCode;
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
     * @return string
     */
    public function getSubFamilyCode()
    {
        return $this->subFamilyCode;
    }

    /**
     * @param string $issuer
     */
    public function setSubFamilyCode($issuer)
    {
        $this->subFamilyCode = $issuer;
    }
}
