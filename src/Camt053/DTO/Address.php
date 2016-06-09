<?php

namespace Genkgo\Camt\Camt053\DTO;

/**
 * Class Address
 * @package Genkgo\Camt\Camt053
 */
class Address
{
    /**
     * @var string
     */
    private $country;
    /**
     * @var array
     */
    private $addressLines = [];

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     * @return static
     */
    public function setCountry($country)
    {
        $cloned = clone $this;
        $cloned->country = $country;
        return $cloned;
    }

    /**
     * @return array
     */
    public function getAddressLines()
    {
        return $this->addressLines;
    }

    /**
     * @param array $addressLines
     * @return static
     */
    public function setAddressLines(array $addressLines)
    {
        $cloned = clone $this;
        $cloned->addressLines = $addressLines;
        return $cloned;
    }

    /**
     * @param string $addressLine
     * @return static
     */
    public function addAddressLine($addressLine)
    {
        $cloned = clone $this;
        $cloned->addressLines[] = $addressLine;
        return $cloned;
    }
}
