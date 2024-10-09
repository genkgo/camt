<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

class RemittanceInformation
{
    private ?string $message = null;

    private ?CreditorReferenceInformation $creditorReferenceInformation = null;

    /**
     * @var StructuredRemittanceInformation[]
     */
    private array $structuredBlocks = [];

    /**
     * @var UnstructuredRemittanceInformation[]
     */
    private array $unstructuredBlocks = [];

    public static function fromUnstructured(string $message): self
    {
        $information = new self();
        $information->message = $message;

        return $information;
    }

    public function getCreditorReferenceInformation(): ?CreditorReferenceInformation
    {
        return $this->creditorReferenceInformation;
    }

    public function setCreditorReferenceInformation(CreditorReferenceInformation $creditorReferenceInformation): void
    {
        $this->creditorReferenceInformation = $creditorReferenceInformation;
        $this->message = $creditorReferenceInformation->getRef();
    }

    /**
     * @deprecated Use getStructuredBlocks method instead
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @deprecated Use addStructuredBlock method instead
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

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

    public function getStructuredBlock(): ?StructuredRemittanceInformation
    {
        if (isset($this->structuredBlocks[0])) {
            return $this->structuredBlocks[0];
        }

        return null;
    }

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

    public function getUnstructuredBlock(): ?UnstructuredRemittanceInformation
    {
        if (isset($this->unstructuredBlocks[0])) {
            return $this->unstructuredBlocks[0];
        }

        return null;
    }
}
