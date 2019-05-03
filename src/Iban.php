<?php
namespace Genkgo\Camt;

/**
 * Class Iban
 * @package Genkgo\Camt
 */
class Iban
{
    /**
     * @var string
     */
    private $iban;

    /**
     * @param string $iban
     */
    public function __construct($iban)
    {
        if (!verify_iban($iban)) {
            throw new \InvalidArgumentException("Unknown IBAN {$iban}");
        }
        
        $this->iban = iban_to_machine_format($iban);
    }

    /**
     * @return string
     */
    public function getIban()
    {
        return $this->iban;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->iban;
    }

    public function equals($iban)
    {
        return iban_to_machine_format($iban) === $this->iban;
    }
}
