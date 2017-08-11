<?php

namespace Genkgo\Camt\DTO;

/**
 * Class UnstructuredRemittanceInformation
 * @package Genkgo\Camt\DTO
 */
class UnstructuredRemittanceInformation
{
    /**
     * @var string
     */
    private $message;

    /**
     * @param string $message
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }
}
