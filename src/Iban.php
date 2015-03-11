<?php
namespace Genkgo\Camt;

use IBAN\Validation\IBANValidator;

class Iban {

    private $iban;

    public function __construct($iban) {
        $validator = new IBANValidator();
        if (!$validator->validate($iban)) {
            throw new \InvalidArgumentException("Unknown IBAN {$iban}");
        }
        $this->iban = $iban;
    }

    /**
     * @return mixed
     */
    public function getIban()
    {
        return $this->iban;
    }

    public function __toString() {
        return $this->iban;
    }

}