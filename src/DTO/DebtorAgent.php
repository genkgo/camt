<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

class DebtorAgent implements RelatedAgentTypeInterface
{
    private string $name;

    private string $BIC;

    /**
     * CreditorAgent constructor.
     */
    public function __construct(string $name, string $BIC)
    {
        $this->name = $name;
        $this->BIC = $BIC;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getBIC(): string
    {
        return $this->BIC;
    }

    public function setBIC(string $BIC): void
    {
        $this->BIC = $BIC;
    }
}
