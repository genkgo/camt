<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

use Money\Money;

class EntryTransactionDetail
{
    private ?Reference $reference = null;

    /**
     * @var RelatedParty[]
     */
    private array $relatedParties = [];

    /**
     * @var RelatedAgent[]
     */
    private array $relatedAgents = [];

    private ?RemittanceInformation $remittanceInformation = null;

    private ?RelatedDates $relatedDates = null;

    private ?ReturnInformation $returnInformation = null;

    private ?AdditionalTransactionInformation $additionalTransactionInformation = null;

    private ?BankTransactionCode $bankTransactionCode = null;

    private ?Charges $charges = null;

    private ?Money $amountDetails = null;

    private ?Money $amount = null;

    private ?string $creditDebitIndicator = null;

    public function setReference(?Reference $reference): void
    {
        $this->reference = $reference;
    }

    public function getReference(): ?Reference
    {
        return $this->reference;
    }

    public function addRelatedParty(RelatedParty $relatedParty): void
    {
        $this->relatedParties[] = $relatedParty;
    }

    /**
     * @return RelatedParty[]
     */
    public function getRelatedParties(): array
    {
        return $this->relatedParties;
    }

    public function getRelatedParty(): ?RelatedParty
    {
        if (isset($this->relatedParties[0])) {
            return $this->relatedParties[0];
        }

        return null;
    }

    public function addRelatedAgent(RelatedAgent $relatedAgent): void
    {
        $this->relatedAgents[] = $relatedAgent;
    }

    /**
     * @return RelatedAgent[]
     */
    public function getRelatedAgents(): array
    {
        return $this->relatedAgents;
    }

    public function getRelatedAgent(): ?RelatedAgent
    {
        if (isset($this->relatedAgents[0])) {
            return $this->relatedAgents[0];
        }

        return null;
    }

    public function setRemittanceInformation(?RemittanceInformation $remittanceInformation): void
    {
        $this->remittanceInformation = $remittanceInformation;
    }

    public function getRemittanceInformation(): ?RemittanceInformation
    {
        return $this->remittanceInformation;
    }

    public function setRelatedDates(?RelatedDates $relatedDates): void
    {
        $this->relatedDates = $relatedDates;
    }

    public function getRelatedDates(): ?RelatedDates
    {
        return $this->relatedDates;
    }

    public function getReturnInformation(): ?ReturnInformation
    {
        return $this->returnInformation;
    }

    public function setReturnInformation(?ReturnInformation $information): void
    {
        $this->returnInformation = $information;
    }

    public function setAdditionalTransactionInformation(?AdditionalTransactionInformation $additionalTransactionInformation): void
    {
        $this->additionalTransactionInformation = $additionalTransactionInformation;
    }

    public function getAdditionalTransactionInformation(): ?AdditionalTransactionInformation
    {
        return $this->additionalTransactionInformation;
    }

    public function getBankTransactionCode(): ?BankTransactionCode
    {
        return $this->bankTransactionCode;
    }

    public function setBankTransactionCode(BankTransactionCode $bankTransactionCode): void
    {
        $this->bankTransactionCode = $bankTransactionCode;
    }

    public function getCharges(): ?Charges
    {
        return $this->charges;
    }

    public function setCharges(?Charges $charges): void
    {
        $this->charges = $charges;
    }

    public function getAmountDetails(): ?Money
    {
        return $this->amountDetails;
    }

    public function setAmountDetails(?Money $amountDetails): void
    {
        $this->amountDetails = $amountDetails;
    }

    public function getAmount(): ?Money
    {
        return $this->amount;
    }

    public function setAmount(?Money $amount): void
    {
        $this->amount = $amount;
    }

    public function getCreditDebitIndicator(): ?string
    {
        return $this->creditDebitIndicator;
    }

    public function setCreditDebitIndicator(?string $creditDebitIndicator): void
    {
        $this->creditDebitIndicator = $creditDebitIndicator;
    }
}
