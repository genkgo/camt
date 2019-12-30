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
    public function getAdditionalRemittanceInformation()
    {
        return $this->additionalRemittanceInformation;
    }

    /**
     * @param null|string $additionalRemittanceInformation
     */
    public function setAdditionalRemittanceInformation($additionalRemittanceInformation)
    {
        $this->additionalRemittanceInformation = $additionalRemittanceInformation;
    }

    /**
     * @return null|CreditorReferenceInformation
     */
    public function getCreditorReferenceInformation()
    {
        return $this->creditorReferenceInformation;
    }

    /**
     * @param null|CreditorReferenceInformation $creditorReferenceInformation
     */
    public function setCreditorReferenceInformation(?CreditorReferenceInformation $creditorReferenceInformation)
    {
        $this->creditorReferenceInformation = $creditorReferenceInformation;
    }
}
