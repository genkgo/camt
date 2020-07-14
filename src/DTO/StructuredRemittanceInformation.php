<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

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

    public function getAdditionalRemittanceInformation(): ?string
    {
        return $this->additionalRemittanceInformation;
    }

    public function setAdditionalRemittanceInformation(?string $additionalRemittanceInformation): void
    {
        $this->additionalRemittanceInformation = $additionalRemittanceInformation;
    }

    public function getCreditorReferenceInformation(): ?CreditorReferenceInformation
    {
        return $this->creditorReferenceInformation;
    }

    public function setCreditorReferenceInformation(?CreditorReferenceInformation $creditorReferenceInformation): void
    {
        $this->creditorReferenceInformation = $creditorReferenceInformation;
    }
}
