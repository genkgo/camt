<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

class ProprietaryAccount extends Account
{
    /**
     * @var string
     */
    private $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

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
