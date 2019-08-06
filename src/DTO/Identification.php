<?php

namespace Genkgo\Camt\DTO;

abstract class Identification
{
    /**
     * @var null|string
     */
    protected $identification;

    /**
     * @return null|string
     */
    public function getIdentification(): ?string
    {
        return $this->identification;
    }

    /**
     * @param string $identification
     */
    public function setIdentification($identification)
    {
        $this->identification = $identification;
    }
}
