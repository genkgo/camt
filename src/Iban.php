<?php
namespace Genkgo\Camt;

use IBAN\Validation\IBANValidator;

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
        $validator = new IBANValidator();
        if (!$validator->validate($iban)) {
            throw new \InvalidArgumentException("Unknown IBAN {$iban}");
        }
        $this->iban = $iban;
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
}
