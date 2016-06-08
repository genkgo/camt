<?php

namespace Genkgo\Camt\Camt053\DTO;

/**
 * Interface RelatedPartyTypeInterface
 * @package Genkgo\Camt\Camt053
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
