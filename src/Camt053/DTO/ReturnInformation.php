<?php

namespace Genkgo\Camt\Camt053\DTO;

/**
 * Class ReturnInformation
 * @package Genkgo\Camt\Camt053
 */
class ReturnInformation
{
    /**
     * @var string
     */
    private $code;
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
     * @param $code
     * @param $additionalInformation
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
