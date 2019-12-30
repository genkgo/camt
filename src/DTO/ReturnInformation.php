<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

/**
 * Class ReturnInformation
 * @package Genkgo\Camt\DTO
 */
class ReturnInformation
{
    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $additionalInformation;

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getAdditionalInformation(): string
    {
        return $this->additionalInformation;
    }

    /**
     * @param string $code
     * @param string $additionalInformation
     *
     * @return self
     */
    public static function fromUnstructured(string $code, string $additionalInformation): ReturnInformation
    {
        $information = new self();
        $information->code = $code;
        $information->additionalInformation = $additionalInformation;
        return $information;
    }
}
