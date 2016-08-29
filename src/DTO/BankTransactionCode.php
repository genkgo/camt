<?php
/**
 * Created by IntelliJ IDEA.
 * User: bdudelsack
 * Date: 29.08.16
 * Time: 13:17
 */

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
    public function setProprietary($proprietary)
    {
        $this->proprietary = $proprietary;
    }
}