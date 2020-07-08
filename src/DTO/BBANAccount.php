<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

class BBANAccount extends Account
{
    /**
     * @var string
     */
    private $bban;

    public function __construct(string $bban)
    {
        $this->bban = $bban;
    }

    public function getBban(): string
    {
        return (string) $this->bban;
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentification(): string
    {
        return (string) $this->bban;
    }
}
