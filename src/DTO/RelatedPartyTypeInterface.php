<?php

namespace Genkgo\Camt\DTO;

/**
 * Interface RelatedPartyTypeInterface
 * @package Genkgo\Camt\DTO
 */
interface RelatedPartyTypeInterface
{

    /**
     * @param Address $address
     * @return mixed
     */
    public function setAddress(Address $address);

    /**
     * @return Address
     */
    public function getAddress();

    /**
     * @return mixed
     */
    public function getName();
}
