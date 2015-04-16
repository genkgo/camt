<?php
namespace Genkgo\Camt\Camt053;
use BadMethodCallException;

/**
 * Class RelatedParty
 * @package Genkgo\Camt\Camt053
 */
class RelatedParty
{
    /**
     * @var Creditor
     */
    private $creditor;
    /**
     * @var Account
     */
    private $account;

    /**
     * @param Creditor $creditor
     * @param Account $account
     */
    public function __construct(Creditor $creditor, Account $account = null)
    {
        $this->creditor = $creditor;
        $this->account = $account;
    }

    /**
     * @return Creditor
     */
    public function getCreditor()
    {
        return $this->creditor;
    }

    /**
     * @return Account
     */
    public function getAccount()
    {
        if ($this->account === null) {
            throw new BadMethodCallException();
        }
        return $this->account;
    }
}
