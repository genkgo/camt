<?php

namespace Genkgo\Camt\DTO;

/**
 * Class ProprietaryReference
 * @package Genkgo\Camt\DTO
 */
class ProprietaryReference
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $reference;

    /**
     * @param string $type
     * @param string $reference
     */
    public function __construct($type, $reference)
    {
        $this->type = $type;
        $this->reference = $reference;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }
}
