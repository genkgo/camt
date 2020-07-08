<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

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

    public function __construct(RelatedPartyTypeInterface $relatedPartyDetails, ?Account $account)
    {
        $this->relatedPartyDetails = $relatedPartyDetails;
        $this->account = $account;
    }

    public function getRelatedPartyType(): RelatedPartyTypeInterface
    {
        return $this->relatedPartyDetails;
    }

    public function getAccount(): ?Account
    {
        return $this->account;
    }
}
