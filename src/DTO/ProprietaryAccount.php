<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

/**
 * Class ProprietaryAccount
 * @package Genkgo\Camt
 */
class ProprietaryAccount extends Account
{
    /**
     * @var string
     */
    private $id;

    /**
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return (string) $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentification(): string
    {
        return (string) $this->id;
    }
}
