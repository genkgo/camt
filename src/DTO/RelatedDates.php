<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

use DateTimeImmutable;

/**
 * Class RelatedDates
 *
 * @package Genkgo\Camt\DTO
 */
class RelatedDates
{

    /**
     * @var DateTimeImmutable
     */
    private $acceptanceDateTime;

    /**
     * @return DateTimeImmutable
     */
    public function getAcceptanceDateTime(): DateTimeImmutable
    {
        return $this->acceptanceDateTime;
    }

    /**
     * @param DateTimeImmutable $acceptanceDateTime
     *
     * @return self
     */
    public static function fromUnstructured(DateTimeImmutable $acceptanceDateTime): RelatedDates
    {
        $information = new self();
        $information->acceptanceDateTime = $acceptanceDateTime;

        return $information;
    }
}
