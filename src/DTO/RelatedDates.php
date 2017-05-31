<?php

namespace Genkgo\Camt\DTO;

/**
 * Class RelatedDates
 * @package Genkgo\Camt\DTO
 */
class RelatedDates
{
    
    /**
     * @var AcceptanceDateTime
     */
    private $acceptanceDateTime;

    /**
     * @return AcceptanceDateTime
     */
    public function getAcceptanceDateTime()
    {
        return $this->acceptanceDateTime;
    }

    /**
     * @param $acceptanceDateTime
     *
     * @return static
     */
    public static function fromUnstructured($acceptanceDateTime)
    {
        $information = new static;
        $information->acceptanceDateTime = $acceptanceDateTime;
        return $information;
    }

}
