<?php

declare(strict_types=1);
namespace Genkgo\Camt\DTO;

class BankTransactionCode
{
    /** @var ProprietaryBankTransactionCode */
    private $proprietary;

    /** @var DomainBankTransactionCode */
    private $domain;

    /**
     * @return ProprietaryBankTransactionCode|null
     */
    public function getProprietary(): ?ProprietaryBankTransactionCode
    {
        return $this->proprietary;
    }

    /**
     * @param ProprietaryBankTransactionCode $proprietary
     */
    public function setProprietary(ProprietaryBankTransactionCode $proprietary): void
    {
        $this->proprietary = $proprietary;
    }

    /**
     * @return DomainBankTransactionCode|null
     */
    public function getDomain(): ?DomainBankTransactionCode
    {
        return $this->domain;
    }

    /**
     * @param DomainBankTransactionCode $domain
     */
    public function setDomain(DomainBankTransactionCode $domain): void
    {
        $this->domain = $domain;
    }
}
