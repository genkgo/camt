<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

class BankTransactionCode
{
    /**
     * @var ProprietaryBankTransactionCode
     */
    private $proprietary;

    /**
     * @var DomainBankTransactionCode
     */
    private $domain;

    public function getProprietary(): ProprietaryBankTransactionCode
    {
        return $this->proprietary;
    }

    public function setProprietary(ProprietaryBankTransactionCode $proprietary): void
    {
        $this->proprietary = $proprietary;
    }

    public function getDomain(): DomainBankTransactionCode
    {
        return $this->domain;
    }

    public function setDomain(DomainBankTransactionCode $domain): void
    {
        $this->domain = $domain;
    }
}
