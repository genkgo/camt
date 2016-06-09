<?php

namespace Genkgo\Camt\Camt053\Decoder;

use Genkgo\Camt\Camt053\DTO;
use \SimpleXMLElement;
use Genkgo\Camt\Iban;

class EntryTransactionDetail
{
    /**
     * @param DTO\EntryTransactionDetail $detail
     * @param SimpleXMLElement           $xmlDetail
     */
    public function addReferences(DTO\EntryTransactionDetail $detail, SimpleXMLElement $xmlDetail)
    {
        if (false === isset($xmlDetail->Refs->EndToEndId)) {
            return;
        }

        $endToEndId = (string)$xmlDetail->Refs->EndToEndId;
        $mandateId = null;

        if (isset($xmlDetail->Refs->MndtId)) {
            $mandateId = (string)$xmlDetail->Refs->MndtId;
        }

        $detail->addReference(new DTO\Reference($endToEndId, $mandateId));
    }

    /**
     * @param DTO\EntryTransactionDetail $detail
     * @param SimpleXMLElement           $xmlDetail
     */
    public function addRelatedParties(DTO\EntryTransactionDetail $detail, SimpleXMLElement $xmlDetail)
    {
        if (false === isset($xmlDetail->RltdPties)) {
            return;
        }

        foreach ($xmlDetail->RltdPties as $xmlRelatedParty) {
            if (isset($xmlRelatedParty->Cdtr)) {
                $xmlRelatedPartyType = $xmlRelatedParty->Cdtr;
                $xmlRelatedPartyTypeAccount = $xmlRelatedParty->CdtrAcct;
                $relatedPartyType = $creditor = new DTO\Creditor((string) $xmlRelatedPartyType->Nm);
            } elseif (isset($xmlRelatedParty->Dbtr)) {
                $xmlRelatedPartyType = $xmlRelatedParty->Dbtr;
                $xmlRelatedPartyTypeAccount = $xmlRelatedParty->DbtrAcct;
                $relatedPartyType = $creditor = new DTO\Debtor((string) $xmlRelatedPartyType->Nm);
            } else {
                continue;
            }

            if (isset($xmlRelatedPartyType->PstlAdr)) {
                $address = new DTO\Address();
                if (isset($xmlRelatedPartyType->PstlAdr->Ctry)) {
                    $address = $address->setCountry((string) $xmlRelatedPartyType->PstlAdr->Ctry);
                }
                if (isset($xmlRelatedPartyType->PstlAdr->AdrLine)) {
                    foreach ($xmlRelatedPartyType->PstlAdr->AdrLine as $line) {
                        $address = $address->addAddressLine((string)$line);
                    }
                }

                $relatedPartyType->setAddress($address);
            }

            $acount = null;
            if (isset($xmlRelatedPartyTypeAccount->Id->IBAN) && $ibanCode = (string) $xmlRelatedPartyTypeAccount->Id->IBAN) {
                $account = new DTO\Account(new Iban($ibanCode));
            }

            $relatedParty = new DTO\RelatedParty($relatedPartyType, $account);
            $detail->addRelatedParty($relatedParty);
        }
    }

    /**
     * @param DTO\EntryTransactionDetail $detail
     * @param SimpleXMLElement           $xmlDetail
     */
    public function addRemittanceInformation(DTO\EntryTransactionDetail $detail, SimpleXMLElement $xmlDetail)
    {
        if (false === isset($xmlDetail->RmtInf)) {
            return;
        }

        if (isset($xmlDetail->RmtInf->Ustrd)) {
            $remittanceInformation = DTO\RemittanceInformation::fromUnstructured(
                (string)$xmlDetail->RmtInf->Ustrd
            );
            $detail->setRemittanceInformation($remittanceInformation);

            return;
        }
        
        if (isset($xmlDetail->RmtInf->Strd)
            && isset($xmlDetail->RmtInf->Strd->CdtrRefInf)
            && isset($xmlDetail->RmtInf->Strd->CdtrRefInf->Ref)
        ) {
            $creditorReferenceInformation = DTO\CreditorReferenceInformation::fromUnstructured(
                (string)$xmlDetail->RmtInf->Strd->CdtrRefInf->Ref
            );
            $remittanceInformation = new DTO\RemittanceInformation();
            $remittanceInformation->setCreditorReferenceInformation($creditorReferenceInformation);
            $detail->setRemittanceInformation($remittanceInformation);
        }
    }

    /**
     * @param DTO\EntryTransactionDetail $detail
     * @param SimpleXMLElement           $xmlDetail
     */
    public function addReturnInformation(DTO\EntryTransactionDetail $detail, SimpleXMLElement $xmlDetail)
    {
        if (isset($xmlDetail->RtrInf) && isset($xmlDetail->RtrInf->Rsn->Cd)) {
            $remittanceInformation = DTO\ReturnInformation::fromUnstructured(
                (string)$xmlDetail->RtrInf->Rsn->Cd,
                (string)$xmlDetail->RtrInf->AddtlInf
            );
            $detail->setReturnInformation($remittanceInformation);
        }
    }

    /**
     * @param DTO\EntryTransactionDetail $detail
     * @param SimpleXMLElement           $xmlDetail
     */
    public function addAdditionalTransactionInformation(DTO\EntryTransactionDetail $detail, SimpleXMLElement $xmlDetail)
    {
        if (isset($xmlDetail->AddtlTxInf)) {
            $additionalInformation = new DTO\AdditionalTransactionInformation(
                (string) $xmlDetail->AddtlTxInf
            );
            $detail->setAdditionalTransactionInformation($additionalInformation);
        }
    }
}
