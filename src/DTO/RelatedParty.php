<?php

namespace Genkgo\Camt\DTO;

/**
 * Class RelatedParty
 *
 * @package Genkgo\Camt\DTO
 */
class RelatedParty
{
    /**
     * @var RelatedPartyTypeInterface
     */
    private $relatedPartyDetails;

    /**
     * @var null|Account
     */
    private $account;

    /**
     * @param RelatedPartyTypeInterface $relatedPartyDetails
     * @param null|Account $account
     */
    public function __construct(RelatedPartyTypeInterface $relatedPartyDetails, ?Account $account)
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
     * @return null|Account
     */
    public function getAccount(): ?Account
    {
        return $this->account;
    }
}
