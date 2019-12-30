<?php

declare(strict_types=1);
namespace Genkgo\Camt\DTO;

interface RelatedAgentTypeInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getBIC(): string;
}
