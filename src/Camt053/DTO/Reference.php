<?php

namespace Genkgo\Camt\Camt053\DTO;

/**
 * Class Reference
 * @package Genkgo\Camt\Camt053
 */
class Reference
{
    /**
     * @var string
     */
    private $endToEndId;

    /**
     * @var string
     */
    private $mandateId;

    /**
     * @param $endToEndId
     * @param $mandateId
     */
    public function __construct($endToEndId, $mandateId = null)
    {
        $this->endToEndId = $endToEndId;
        $this->mandateId = $mandateId;
    }

    /**
     * @return string|null
     */
    public function getMandateId()
    {
        return $this->mandateId;
    }

    /**
     * @return string
     */
    public function getEndToEndId()
    {
        return $this->endToEndId;
    }
}
