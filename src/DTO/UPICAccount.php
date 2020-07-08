<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

class UPICAccount extends Account
{
    /**
     * @var string
     */
    private $upic;

    public function __construct(string $upic)
    {
        $this->upic = $upic;
    }

    public function getUpic(): string
    {
        return (string) $this->upic;
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentification(): string
    {
        return (string) $this->upic;
    }
}
