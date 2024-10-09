<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

use DateTimeImmutable;

class RelatedDates
{
    private DateTimeImmutable $acceptanceDateTime;

    public function getAcceptanceDateTime(): DateTimeImmutable
    {
        return $this->acceptanceDateTime;
    }

    public static function fromUnstructured(DateTimeImmutable $acceptanceDateTime): self
    {
        $information = new self();
        $information->acceptanceDateTime = $acceptanceDateTime;

        return $information;
    }
}
