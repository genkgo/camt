<?php

namespace Genkgo\Camt\Camt053\DTO;

use BadMethodCallException;

/**
 * Class RelatedParty
 * @package Genkgo\Camt\Camt053
 */
class RelatedParty
{
    /**
     * @var RelatedPartyTypeInterface
     */
    private $relatedPartyDetails;
    /**
     * @var Account
     */
    private $account;

    /**
     * @param RelatedPartyTypeInterface $relatedPartyDetails
     * @param Account $account
     */
    public function __construct(RelatedPartyTypeInterface $relatedPartyDetails, Account $account = null)
    {
        $this->relatedPartyDetails = $relatedPartyDetails;
        $this->account = $account;
    }

    /**
     * @return RelatedPartyTypeInterface
     */
    public function getRelatedPartyType()
    {
        return $this->relatedPartyDetails;
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
