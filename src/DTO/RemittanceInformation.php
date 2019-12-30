<?php

namespace Genkgo\Camt\DTO;

/**
 * Class RemittanceInformation
 *
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
     *
     * @return self
     */
    public static function fromUnstructured(string $message): RemittanceInformation
    {
        $information = new self();
        $information->message = $message;

        return $information;
    }

    /**
     * @return null|CreditorReferenceInformation
     */
    public function getCreditorReferenceInformation(): ?CreditorReferenceInformation
    {
        return $this->creditorReferenceInformation;
    }

    /**
     * @param CreditorReferenceInformation $creditorReferenceInformation
     */
    public function setCreditorReferenceInformation(CreditorReferenceInformation $creditorReferenceInformation): void
    {
        $this->creditorReferenceInformation = $creditorReferenceInformation;
        $this->message = $creditorReferenceInformation->getRef();
    }

    /**
     * @return null|string
     * @deprecated Use getStructuredBlocks method instead
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string $message
     *
     * @deprecated Use addStructuredBlock method instead
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * @param StructuredRemittanceInformation $structuredRemittanceInformation
     */
    public function addStructuredBlock(StructuredRemittanceInformation $structuredRemittanceInformation): void
    {
        $this->structuredBlocks[] = $structuredRemittanceInformation;
    }

    /**
     * @return StructuredRemittanceInformation[]
     */
    public function getStructuredBlocks(): array
    {
        return $this->structuredBlocks;
    }

    /**
     * @return null|StructuredRemittanceInformation
     */
    public function getStructuredBlock(): ?StructuredRemittanceInformation
    {
        if (isset($this->structuredBlocks[0])) {
            return $this->structuredBlocks[0];
        }

        return null;
    }

    /**
     * @param UnstructuredRemittanceInformation $unstructuredRemittanceInformation
     */
    public function addUnstructuredBlock(UnstructuredRemittanceInformation $unstructuredRemittanceInformation): void
    {
        $this->unstructuredBlocks[] = $unstructuredRemittanceInformation;
    }

    /**
     * @return UnstructuredRemittanceInformation[]
     */
    public function getUnstructuredBlocks(): array
    {
        return $this->unstructuredBlocks;
    }

    /**
     * @return UnstructuredRemittanceInformation
     */
    public function getUnstructuredBlock(): ?UnstructuredRemittanceInformation
    {
        if (isset($this->unstructuredBlocks[0])) {
            return $this->unstructuredBlocks[0];
        }

        return null;
    }
}
