<?php

declare(strict_types=1);

namespace Genkgo\Camt\Decoder;

use Genkgo\Camt\DTO;
use SimpleXMLElement;

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

    public function addTransactionDetails(DTO\Entry $entry, SimpleXMLElement $xmlEntry): void
    {
        $xmlDetails = $xmlEntry->NtryDtls->TxDtls;
        if (!is_iterable($xmlDetails) || count($xmlDetails) === 0) { // 052.v1 TxDtls are in different location
            $xmlDetails = $xmlEntry->TxDtls;
        }

        foreach ($xmlDetails as $xmlDetail) {
            $detail = new DTO\EntryTransactionDetail();
            $this->entryTransactionDetailDecoder->addReference($detail, $xmlDetail);
            $this->entryTransactionDetailDecoder->addRelatedParties($detail, $xmlDetail);
            $this->entryTransactionDetailDecoder->addRelatedAgents($detail, $xmlDetail);
            $this->entryTransactionDetailDecoder->addRemittanceInformation($detail, $xmlDetail);
            $this->entryTransactionDetailDecoder->addRelatedDates($detail, $xmlDetail);
            $this->entryTransactionDetailDecoder->addReturnInformation($detail, $xmlDetail);
            $this->entryTransactionDetailDecoder->addAdditionalTransactionInformation($detail, $xmlDetail);
            $this->entryTransactionDetailDecoder->addBankTransactionCode($detail, $xmlDetail);
            $this->entryTransactionDetailDecoder->addCharges($detail, $xmlDetail);
            $this->entryTransactionDetailDecoder->addAmountDetails($detail, $xmlDetail, $xmlEntry->CdtDbtInd);
            $this->entryTransactionDetailDecoder->addAmount($detail, $xmlDetail, $xmlEntry->CdtDbtInd);

            $entry->addTransactionDetail($detail);
        }
    }
}
