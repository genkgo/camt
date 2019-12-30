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
    public function getRef(): string
    {
        return $this->ref;
    }

    /**
     * @param string $ref
     */
    public function setRef(string $ref): void
    {
        $this->ref = $ref;
    }

    /**
     * @param string $ref
     *
     * @return self
     */
    public static function fromUnstructured(string $ref): CreditorReferenceInformation
    {
        $information = new self();
        $information->ref = $ref;
        return $information;
    }

    /**
     * @return null|string
     */
    public function getProprietary(): ?string
    {
        return $this->proprietary;
    }

    /**
     * @param null|string $proprietary
     */
    public function setProprietary(?string $proprietary): void
    {
        $this->proprietary = $proprietary;
    }

    /**
     * @return null|string
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param null|string $code
     */
    public function setCode(?string $code): void
    {
        $this->code = $code;
    }
}
