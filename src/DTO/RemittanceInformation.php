<?php

namespace Genkgo\Camt\DTO;

use BadMethodCallException;

/**
 * Class RemittanceInformation
 * @package Genkgo\Camt\DTO
 */
class RemittanceInformation
{
    /**
     * @var null|string
     */
    private $message;

    /**
     * @var null|CreditorReferenceInformation
     */
    private $creditorReferenceInformation;

    /**
     * @var StructuredRemittanceInformation[]
     */
    private $structuredBlocks = [];

    /**
     * @var UnstructuredRemittanceInformation[]
     */
    private $unstructuredBlocks = [];

    /**
     * @param string $message
     * @return static
     */
    public static function fromUnstructured($message)
    {
        $information = new static;
        $information->message = $message;
        return $information;
    }

    /**
     * @return null|CreditorReferenceInformation
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
     * @deprecated Use getStructuredBlocks method instead
     * @return null|string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @deprecated Use addStructuredBlock method instead
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @param StructuredRemittanceInformation $structuredRemittanceInformation
     */
    public function addStructuredBlock(StructuredRemittanceInformation $structuredRemittanceInformation)
    {
        $this->structuredBlocks[] = $structuredRemittanceInformation;
    }

    /**
     * @return StructuredRemittanceInformation[]
     */
    public function getStructuredBlocks()
    {
        return $this->structuredBlocks;
    }

    /**
     * @return StructuredRemittanceInformation
     */
    public function getStructuredBlock()
    {
        if (isset($this->structuredBlocks[0])) {
            return $this->structuredBlocks[0];
        } else {
            throw new BadMethodCallException('There are no structured block at all for this remittance information');
        }
    }

    /**
     * @param UnstructuredRemittanceInformation $unstructuredRemittanceInformation
     */
    public function addUnstructuredBlock(UnstructuredRemittanceInformation $unstructuredRemittanceInformation)
    {
        $this->unstructuredBlocks[] = $unstructuredRemittanceInformation;
    }

    /**
     * @return UnstructuredRemittanceInformation[]
     */
    public function getUnstructuredBlocks()
    {
        return $this->unstructuredBlocks;
    }

    /**
     * @return UnstructuredRemittanceInformation
     */
    public function getUnstructuredBlock()
    {
        if (isset($this->unstructuredBlocks[0])) {
            return $this->unstructuredBlocks[0];
        } else {
            throw new BadMethodCallException('There are no unstructured block at all for this remittance information');
        }
    }
}
