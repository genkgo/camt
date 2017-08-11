<?php
namespace Genkgo\Camt\DTO;

class BankTransactionCode
{
    /** @var ProprietaryBankTransactionCode */
    private $proprietary;

    /** @var DomainBankTransactionCode */
    private $domain;

    /**
     * @return ProprietaryBankTransactionCode
     */
    public function getProprietary()
    {
        return $this->proprietary;
    }

    /**
     * @param ProprietaryBankTransactionCode $proprietary
     */
    public function setProprietary(ProprietaryBankTransactionCode $proprietary)
    {
        $this->proprietary = $proprietary;
    }

    /**
     * @return DomainBankTransactionCode
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * @param DomainBankTransactionCode $domain
     */
    public function setDomain(DomainBankTransactionCode $domain)
    {
        $this->domain = $domain;
    }
}
