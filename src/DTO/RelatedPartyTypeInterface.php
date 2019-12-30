<?php

namespace Genkgo\Camt\DTO;

/**
 * Interface RelatedPartyTypeInterface
 *
 * @package Genkgo\Camt\DTO
 */
interface RelatedPartyTypeInterface
{
    /**
     * @param Address $address
     */
    public function setAddress(Address $address);

    /**
     * @return null|Address
     */
    public function getAddress(): ?Address;

    /**
     * @return null|string
     */
    public function getName(): ?string;
}
