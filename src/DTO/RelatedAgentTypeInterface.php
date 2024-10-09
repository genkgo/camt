<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

interface RelatedAgentTypeInterface
{
    public function getName(): string;

    public function getBIC(): string;
}
