<?php

namespace Genkgo\Camt\DTO;

/**
 * Class StructuredRemittanceInformation
 * @package Genkgo\Camt\DTO
 */
class StructuredRemittanceInformation
{
    /**
     * @var null|CreditorReferenceInformation
     */
    private $creditorReferenceInformation;

    /**
     * @var null|string
     */
    private $additionalRemittanceInformation;

    /**
     * @return null|string
     */
    public function getAdditionalRemittanceInformation(): ?string
    {
        return $this->additionalRemittanceInformation;
    }

    /**
     * @param null|string $additionalRemittanceInformation
     */
    public function setAdditionalRemittanceInformation(?string $additionalRemittanceInformation): void
    {
        $this->additionalRemittanceInformation = $additionalRemittanceInformation;
    }

    /**
     * @return null|CreditorReferenceInformation
     */
    public function getCreditorReferenceInformation(): ?CreditorReferenceInformation
    {
        return $this->creditorReferenceInformation;
    }

    /**
     * @param null|CreditorReferenceInformation $creditorReferenceInformation
     */
    public function setCreditorReferenceInformation(?CreditorReferenceInformation $creditorReferenceInformation): void
    {
        $this->creditorReferenceInformation = $creditorReferenceInformation;
    }
}
