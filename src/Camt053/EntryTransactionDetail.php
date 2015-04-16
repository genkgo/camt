<?php
namespace Genkgo\Camt\Camt053;

use BadMethodCallException;

/**
 * Class EntryTransactionDetail
 * @package Genkgo\Camt\Camt053
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
     * @var
     */
    private $remittanceInformation;

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
     * @return Reference
     * @throws BadMethodCallException
     */
    public function getReference()
    {
        if (isset($this->references[0])) {
            return $this->references[0];
        } else {
            throw new BadMethodCallException('There are no references at all for this transaction');
        }
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
     * @return RelatedParty
     * @throws BadMethodCallException
     */
    public function getRelatedParty()
    {
        if (isset($this->relatedParties[0])) {
            return $this->relatedParties[0];
        } else {
            throw new BadMethodCallException('There are no related parties at all for this transaction');
        }
    }

    /**
     * @param RemittanceInformation $remittanceInformation
     */
    public function setRemittanceInformation(RemittanceInformation $remittanceInformation)
    {
        $this->remittanceInformation = $remittanceInformation;
    }

    /**
     * @return RemittanceInformation
     */
    public function getRemittanceInformation()
    {
        if ($this->remittanceInformation === null) {
            throw new BadMethodCallException();
        }
        return $this->remittanceInformation;
    }
}
