<?php
namespace Genkgo\Camt;

use Iban\Validation\Validator;
use Iban\Validation\Iban as IbanDetails;

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

    public function __construct(string $iban)
    {
        $iban = new IbanDetails($iban);

        if (!(new Validator)->validate($iban)) {
            throw new \InvalidArgumentException("Unknown IBAN {$iban}");
        }

        $this->iban = $iban->getNormalizedIban();
    }

    public function getIban(): string
    {
        return $this->iban;
    }

    public function __toString(): string
    {
        return $this->iban;
    }

    public function equals($iban): bool
    {
        return (new IbanDetails($iban))->getNormalizedIban() === $this->iban;
    }
}
