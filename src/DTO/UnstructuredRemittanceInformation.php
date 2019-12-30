<?php

declare(strict_types=1);

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
    public function __construct(string $message)
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }
}
