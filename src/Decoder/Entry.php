<?php

namespace Genkgo\Camt\Decoder;

use Genkgo\Camt\DTO;
use \SimpleXMLElement;

class Entry
{
    /**
     * @var EntryTransactionDetail
     */
    private $entryTransactionDetailDecoder;

    public function __construct(EntryTransactionDetail $entryTransactionDetailDecoder)
    {
        $this->entryTransactionDetailDecoder = $entryTransactionDetailDecoder;
    }

    /**
     * @param DTO\Entry        $entry
     * @param SimpleXMLElement $xmlEntry
     */
    public function addTransactionDetails(DTO\Entry $entry, SimpleXMLElement $xmlEntry)
    {
        $xmlDetails = $xmlEntry->NtryDtls->TxDtls;

        if ($xmlDetails) {
            foreach ($xmlDetails as $xmlDetail) {
                $detail = new DTO\EntryTransactionDetail();
                $this->entryTransactionDetailDecoder->addReferences($detail, $xmlDetail);
                $this->entryTransactionDetailDecoder->addRelatedParties($detail, $xmlDetail);
                $this->entryTransactionDetailDecoder->addRelatedAgents($detail, $xmlDetail);
                $this->entryTransactionDetailDecoder->addRemittanceInformation($detail, $xmlDetail);
                $this->entryTransactionDetailDecoder->addReturnInformation($detail, $xmlDetail);
                $this->entryTransactionDetailDecoder->addAdditionalTransactionInformation($detail, $xmlDetail);

                $entry->addTransactionDetail($detail);
            }
        }
    }
}
