<?php

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
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getAdditionalInformation()
    {
        return $this->additionalInformation;
    }

    /**
     * @param string $code
     * @param string $additionalInformation
     *
     * @return static
     */
    public static function fromUnstructured($code, $additionalInformation)
    {
        $information = new static;
        $information->code = $code;
        $information->additionalInformation = $additionalInformation;
        return $information;
    }
}
