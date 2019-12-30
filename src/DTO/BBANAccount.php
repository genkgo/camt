<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

/**
 * Class BBANAccount
 * @package Genkgo\Camt
 */
class BBANAccount extends Account
{
    /**
     * @var string
     */
    private $bban;

    /**
     * @param string $bban
     */
    public function __construct(string $bban)
    {
        $this->bban = $bban;
    }

    /**
     * @return string
     */
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
