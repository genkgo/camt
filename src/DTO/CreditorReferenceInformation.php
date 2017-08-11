<?php

namespace Genkgo\Camt\DTO;

/**
 * Class CreditorReferenceInformation
 * @package Genkgo\Camt\DTO
 */
class CreditorReferenceInformation
{
    /**
     * @var string
     */
    private $ref;

    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $proprietary;

    /**
     * @return string
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * @param string $ref
     */
    public function setRef($ref)
    {
        $this->ref = $ref;
    }

    /**
     * @param $ref
     *
     * @return static
     */
    public static function fromUnstructured($ref)
    {
        $information = new static;
        $information->ref = $ref;
        return $information;
    }

    /**
     * @return string
     */
    public function getProprietary()
    {
        return $this->proprietary;
    }

    /**
     * @param string $proprietary
     */
    public function setProprietary($proprietary)
    {
        $this->proprietary = $proprietary;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }
}
