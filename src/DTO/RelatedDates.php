<?php

namespace Genkgo\Camt\DTO;

use DateTimeImmutable;

/**
 * Class RelatedDates
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
    public function getAcceptanceDateTime()
    {
        return $this->acceptanceDateTime;
    }

    /**
     * @param DateTimeImmutable $acceptanceDateTime
     *
     * @return self
     */
    public static function fromUnstructured($acceptanceDateTime)
    {
        $information = new self();
        $information->acceptanceDateTime = $acceptanceDateTime;
        return $information;
    }
}
