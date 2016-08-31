<?php
namespace Genkgo\Camt\DTO;

class BankTransactionCode
{
    /** @var ProprietaryBankTransactionCode */
    private $proprietary;

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
}
