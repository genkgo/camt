<?php
namespace Genkgo\Camt;

use Iban\Validation\Validator;

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
        $validator = new Validator();
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

    public function equals($iban)
    {
        if ($iban === $this->iban) {
            return true;
        }

        return preg_replace('/[^A-Za-z0-9]/', '', $iban) === $this->iban;
    }
}
