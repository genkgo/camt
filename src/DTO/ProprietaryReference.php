<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

class ProprietaryReference
{
    /**
     * @var null|string
     */
    private $type;

    /**
     * @var null|string
     */
    private $reference;

    public function __construct(?string $type, ?string $reference)
    {
        $this->type = $type;
        $this->reference = $reference;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }
}
