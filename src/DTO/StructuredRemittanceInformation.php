<?php

namespace Genkgo\Camt\DTO;

/**
 * Class StructuredRemittanceInformation
 * @package Genkgo\Camt\DTO
 */
class StructuredRemittanceInformation
{
    /**
     * @var CreditorReferenceInformation
     */
    private $creditorReferenceInformation;

    /**
     * @var string
     */
    private $additionalRemittanceInformation;

    /**
     * @return string
     */
    public function getAdditionalRemittanceInformation()
    {
        return $this->additionalRemittanceInformation;
    }

    /**
     * @param string $additionalRemittanceInformation
     */
    public function setAdditionalRemittanceInformation($additionalRemittanceInformation)
    {
        $this->additionalRemittanceInformation = $additionalRemittanceInformation;
    }

    /**
     * @return CreditorReferenceInformation
     */
    public function getCreditorReferenceInformation()
    {
        return $this->creditorReferenceInformation;
    }

    /**
     * @param string $creditorReferenceInformation
     */
    public function setCreditorReferenceInformation(CreditorReferenceInformation $creditorReferenceInformation)
    {
        $this->creditorReferenceInformation = $creditorReferenceInformation;
    }
}
