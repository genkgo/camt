<?php
/**
 * Created by IntelliJ IDEA.
 * User: bdudelsack
 * Date: 29.08.16
 * Time: 13:18
 */

namespace Genkgo\Camt\DTO;


class ProprietaryBankTransactionCode
{
    /** @var string */
    private $code;
    /** @var string */
    private $issuer;

    /**
     * ProprietaryBankTransactionCode constructor.
     * @param string $code
     * @param string $issuer
     */
    public function __construct($code, $issuer)
    {
        $this->code = $code;
        $this->issuer = $issuer;
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
    public function getIssuer()
    {
        return $this->issuer;
    }

    /**
     * @param string $issuer
     */
    public function setIssuer($issuer)
    {
        $this->issuer = $issuer;
    }
}