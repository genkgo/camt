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
     * @var Reference[]
     */
    private $references = [];
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
     * @var RelatedDates
     */
    private $relatedDates;
    /**
     * @var ReturnInformation
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
     * @var Charges
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
     * @param Reference $reference
     */
    public function addReference(Reference $reference)
    {
        $this->references[] = $reference;
    }

    /**
     * @return Reference[]
     */
    public function getReferences()
    {
        return $this->references;
    }

    /**
     * @return null|Reference
     */
    public function getReference(): ?Reference
    {
        if (isset($this->references[0])) {
            return $this->references[0];
        }

        return null;
    }

    /**
     * @param RelatedParty $relatedParty
     */
    public function addRelatedParty(RelatedParty $relatedParty)
    {
        $this->relatedParties[] = $relatedParty;
    }

    /**
     * @return RelatedParty[]
     */
    public function getRelatedParties()
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
    public function addRelatedAgent(RelatedAgent $relatedAgent)
    {
        $this->relatedAgents[] = $relatedAgent;
    }

    /**
     * @return RelatedAgent[]
     */
    public function getRelatedAgents()
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
    public function setRemittanceInformation(?RemittanceInformation $remittanceInformation)
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
     * @param RelatedDates $relatedDates
     */
    public function setRelatedDates(RelatedDates $relatedDates)
    {
        $this->relatedDates = $relatedDates;
    }

    /**
     * @return RelatedDates
     */
    public function getRelatedDates()
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
     * @param ReturnInformation $information
     */
    public function setReturnInformation(ReturnInformation $information)
    {
        $this->returnInformation = $information;
    }

    /**
     * @param null|AdditionalTransactionInformation $additionalTransactionInformation
     */
    public function setAdditionalTransactionInformation(?AdditionalTransactionInformation $additionalTransactionInformation)
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
    public function getBankTransactionCode()
    {
        return $this->bankTransactionCode;
    }

    /**
     * @param BankTransactionCode $bankTransactionCode
     */
    public function setBankTransactionCode(BankTransactionCode $bankTransactionCode)
    {
        $this->bankTransactionCode = $bankTransactionCode;
    }

    /**
     * @return Charges
     */
    public function getCharges()
    {
        return $this->charges;
    }

    /**
     * @param Charges $charges
     */
    public function setCharges(Charges $charges)
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
    public function setAmountDetails(?Money $amountDetails)
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
    public function setAmount(?Money $amount)
    {
        $this->amount = $amount;
    }
}
