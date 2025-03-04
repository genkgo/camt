<?php

declare(strict_types=1);

namespace Genkgo\Camt;

use Iban\Validation\Iban as IbanDetails;
use Iban\Validation\Validator;
use InvalidArgumentException;

class Iban
{
    private string $iban;

    public function __construct(string $iban)
    {
        // Skip IBAN validation for 8-digit account numbers (UK format)
        if (preg_match('/^[0-9]{8}$/', $iban)) {
            $this->iban = $iban;
            return;
        }

        $ibanDetails = new IbanDetails($iban);

        if (!(new Validator())->validate($ibanDetails)) {
            throw new InvalidArgumentException("Unknown IBAN {$iban}");
        }

        $this->iban = $ibanDetails->getNormalizedIban();
    }

    public function getIban(): string
    {
        return $this->iban;
    }

    public function __toString(): string
    {
        return $this->iban;
    }

    public function equals(string $iban): bool
    {
        // Handle comparison with 8-digit account numbers
        if (preg_match('/^[0-9]{8}$/', $iban) && preg_match('/^[0-9]{8}$/', $this->iban)) {
            return $iban === $this->iban;
        }
        
        return (new IbanDetails($iban))->getNormalizedIban() === $this->iban;
    }
}
