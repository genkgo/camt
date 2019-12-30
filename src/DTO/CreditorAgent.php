<?php

declare(strict_types=1);
namespace Genkgo\Camt\DTO;

class CreditorAgent implements RelatedAgentTypeInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $BIC;

    /**
     * CreditorAgent constructor.
     * @param string $name
     * @param string $BIC
     */
    public function __construct(string $name, string $BIC)
    {
        $this->name = $name;
        $this->BIC = $BIC;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getBIC(): string
    {
        return $this->BIC;
    }

    /**
     * @param string $BIC
     */
    public function setBIC(string $BIC): void
    {
        $this->BIC = $BIC;
    }
}
