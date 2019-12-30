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
     * @var null|string
     */
    private $code;

    /**
     * @var null|string
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
     * @param string $ref
     *
     * @return self
     */
    public static function fromUnstructured($ref)
    {
        $information = new self();
        $information->ref = $ref;
        return $information;
    }

    /**
     * @return null|string
     */
    public function getProprietary()
    {
        return $this->proprietary;
    }

    /**
     * @param null|string $proprietary
     */
    public function setProprietary($proprietary)
    {
        $this->proprietary = $proprietary;
    }

    /**
     * @return null|string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param null|string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }
}
