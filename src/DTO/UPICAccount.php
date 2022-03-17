<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

class UPICAccount extends Account
{
    private string $upic;

    public function __construct(string $upic)
    {
        $this->upic = $upic;
    }

    public function getUpic(): string
    {
        return (string) $this->upic;
    }

    /**
     * @inheritDoc
     */
    public function getIdentification(): string
    {
        return (string) $this->upic;
    }
}
