<?php
namespace Genkgo\Camt\Camt053;

class Address {

    private $country;
    private $addressLines = [];

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
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
    public function addAddressLine ($addressLine)
    {
        $cloned = clone $this;
        $cloned->addressLines[] = $addressLine;
        return $cloned;
    }



}