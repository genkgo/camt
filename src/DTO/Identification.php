<?php

declare(strict_types=1);

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
    public function setIdentification(string $identification): void
    {
        $this->identification = $identification;
    }
}
