<?php

namespace Genkgo\Camt\Camt053\DTO;

/**
 * Class CreditorReferenceInformation
 * @package Genkgo\Camt\Camt053
 */
class CreditorReferenceInformation
{
    /**
     * @var string
     */
    private $ref;

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
}
