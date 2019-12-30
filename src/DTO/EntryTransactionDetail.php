<?php

namespace Genkgo\Camt\DTO;

use Money\Money;

/**
 * Class EntryTransactionDetail
 *
 * @package Genkgo\Camt\DTO
 */
class EntryTransactionDetail
{
    /**
     * @var null|Reference
     */
    private $reference;
    /**
     * @var RelatedParty[]
     */
    private $relatedParties = [];
    /**
     * @var RelatedAgent[]
     */
    private $relatedAgents = [];
    /**
     * @var null|RemittanceInformation
     */
    private $remittanceInformation;
    /**
     * @var null|RelatedDates
     */
    private $relatedDates;
    /**
     * @var null|ReturnInformation
     */
    private $returnInformation;
    /**
     * @var null|AdditionalTransactionInformation
     */
    private $additionalTransactionInformation;

    /**
     * @var BankTransactionCode
     */
    private $bankTransactionCode;

    /**
     * @var null|Charges
     */
    private $charges;

    /**
     * @var null|Money
     */
    private $amountDetails;

    /**
     * @var null|Money
     */
    private $amount;

    /**
     * @param null|Reference $reference
     */
    public function setReference(?Reference $reference): void
    {
        $this->reference = $reference;
    }

    /**
     * @return null|Reference
     */
    public function getReference(): ?Reference
    {
        return $this->reference;
    }

    /**
     * @param RelatedParty $relatedParty
     */
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

    /**
     * @return null|RelatedParty
     */
    public function getRelatedParty(): ?RelatedParty
    {
        if (isset($this->relatedParties[0])) {
            return $this->relatedParties[0];
        }

        return null;
    }

    /**
     * @param RelatedAgent $relatedAgent
     */
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

    /**
     * @return null|RelatedAgent
     */
    public function getRelatedAgent(): ?RelatedAgent
    {
        if (isset($this->relatedAgents[0])) {
            return $this->relatedAgents[0];
        }

        return null;
    }

    /**
     * @param null|RemittanceInformation $remittanceInformation
     */
    public function setRemittanceInformation(?RemittanceInformation $remittanceInformation): void
    {
        $this->remittanceInformation = $remittanceInformation;
    }

    /**
     * @return null|RemittanceInformation
     */
    public function getRemittanceInformation(): ?RemittanceInformation
    {
        return $this->remittanceInformation;
    }

    /**
     * @param null|RelatedDates $relatedDates
     */
    public function setRelatedDates(?RelatedDates $relatedDates): void
    {
        $this->relatedDates = $relatedDates;
    }

    /**
     * @return null|RelatedDates
     */
    public function getRelatedDates(): ?RelatedDates
    {
        return $this->relatedDates;
    }

    /**
     * @return null|ReturnInformation
     */
    public function getReturnInformation(): ?ReturnInformation
    {
        return $this->returnInformation;
    }

    /**
     * @param null|ReturnInformation $information
     */
    public function setReturnInformation(?ReturnInformation $information): void
    {
        $this->returnInformation = $information;
    }

    /**
     * @param null|AdditionalTransactionInformation $additionalTransactionInformation
     */
    public function setAdditionalTransactionInformation(?AdditionalTransactionInformation $additionalTransactionInformation): void
    {
        $this->additionalTransactionInformation = $additionalTransactionInformation;
    }

    /**
     * @return null|AdditionalTransactionInformation
     */
    public function getAdditionalTransactionInformation(): ?AdditionalTransactionInformation
    {
        return $this->additionalTransactionInformation;
    }

    /**
     * @return BankTransactionCode
     */
    public function getBankTransactionCode(): BankTransactionCode
    {
        return $this->bankTransactionCode;
    }

    /**
     * @param BankTransactionCode $bankTransactionCode
     */
    public function setBankTransactionCode(BankTransactionCode $bankTransactionCode): void
    {
        $this->bankTransactionCode = $bankTransactionCode;
    }

    /**
     * @return null|Charges
     */
    public function getCharges(): ?Charges
    {
        return $this->charges;
    }

    /**
     * @param null|Charges $charges
     */
    public function setCharges(?Charges $charges): void
    {
        $this->charges = $charges;
    }

    /**
     * @return null|Money
     */
    public function getAmountDetails(): ?Money
    {
        return $this->amountDetails;
    }

    /**
     * @param null|Money $amountDetails
     */
    public function setAmountDetails(?Money $amountDetails): void
    {
        $this->amountDetails = $amountDetails;
    }

    /**
     * @return null|Money
     */
    public function getAmount(): ?Money
    {
        return $this->amount;
    }

    /**
     * @param null|Money $amount
     */
    public function setAmount(?Money $amount): void
    {
        $this->amount = $amount;
    }
}
