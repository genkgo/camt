<?php

namespace Genkgo\Camt\DTO;

/**
 * Class RemittanceInformation
 * @package Genkgo\Camt\DTO
 */
class RemittanceInformation
{
    /**
     * @var string
     */
    private $message;

    /**
     * @var CreditorReferenceInformation
     */
    private $creditorReferenceInformation;

    /**
     * @var StructuredRemittanceInformation
     */
    private $structuredRemittanceInformation;

    /**
     * @var UnstructuredRemittanceInformation
     */
    private $unstructuredRemittanceInformation;

    /**
     * @param $message
     * @return static
     */
    public static function fromUnstructured($message)
    {
        $information = new static;
        $information->message = $message;
        return $information;
    }

    /**
     * @return CreditorReferenceInformation
     */
    public function getCreditorReferenceInformation()
    {
        return $this->creditorReferenceInformation;
    }

    /**
     * @param CreditorReferenceInformation $creditorReferenceInformation
     */
    public function setCreditorReferenceInformation($creditorReferenceInformation)
    {
        $this->creditorReferenceInformation = $creditorReferenceInformation;
        $this->message = $creditorReferenceInformation->getRef();
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return StructuredRemittanceInformation
     */
    public function getStructuredRemittanceInformation()
    {
        return $this->structuredRemittanceInformation;
    }

    /**
     * @param StructuredRemittanceInformation $structuredRemittanceInformation
     */
    public function setStructuredRemittanceInformation(
            StructuredRemittanceInformation $structuredRemittanceInformation)
    {
        $this->structuredRemittanceInformation = $structuredRemittanceInformation;
    }

    /**
     * @return UnstructuredRemittanceInformation
     */
    public function getUnstructuredRemittanceInformation()
    {
        return $this->unstructuredRemittanceInformation;
    }

    /**
     * @param UnstructuredRemittanceInformation $unstructuredRemittanceInformation
     */
    public function setUnstructuredRemittanceInformation(
            UnstructuredRemittanceInformation $unstructuredRemittanceInformation)
    {
        $this->unstructuredRemittanceInformation = $unstructuredRemittanceInformation;
    }
}
