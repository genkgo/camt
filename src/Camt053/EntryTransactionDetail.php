<?php
namespace Genkgo\Camt\Camt053;

/**
 * Class EntryTransactionDetail
 * @package Genkgo\Camt\Camt053
 */
class EntryTransactionDetail {

    /**
     * @var array
     */
    private $references = [];
    /**
     * @var array
     */
    private $relatedParties = [];
    /**
     * @var
     */
    private $remittanceInformation;

    /**
     * @param Reference $reference
     */
    public function addReference (Reference $reference) {
        $this->references[] = $reference;
    }

    /**
     * @return Reference[]
     */
    public function getReferences () {
        return $this->references;
    }

    /**
     * @param RelatedParty $relatedParty
     */
    public function addRelatedParty (RelatedParty $relatedParty) {
        $this->relatedParties[] = $relatedParty;
    }

    /**
     * @return RelatedParty[]
     */
    public function getRelatedParties () {
        return $this->relatedParties;
    }

    /**
     * @param RemittanceInformation $remittanceInformation
     */
    public function setRemittanceInformation (RemittanceInformation $remittanceInformation) {
        $this->remittanceInformation = $remittanceInformation;
    }

    /**
     * @return RemittanceInformation|null
     */
    public function getRemittanceInformation () {
        return $this->remittanceInformation;
    }


}