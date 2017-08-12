<?php

namespace Genkgo\Camt\Decoder;

use Genkgo\Camt\DTO;
use \SimpleXMLElement;
use Genkgo\Camt\Decoder\Factory\DTO as DTOFactory;
use Money\Money;
use Money\Currency;
use Genkgo\Camt\Util\StringToUnits;

abstract class EntryTransactionDetail
{
    /**
     * @var DateDecoderInterface
     */
    private $dateDecoder;

    /**
     * EntryTransactionDetail constructor.
     * @param DateDecoderInterface $dateDecoder
     */
    public function __construct(DateDecoderInterface $dateDecoder)
    {
        $this->dateDecoder = $dateDecoder;
    }

    /**
     * @param DTO\EntryTransactionDetail $detail
     * @param SimpleXMLElement           $xmlDetail
     */
    public function addReferences(DTO\EntryTransactionDetail $detail, SimpleXMLElement $xmlDetail)
    {
        if (false === isset($xmlDetail->Refs)) {
            return;
        }

        $refs = $xmlDetail->Refs;
        $reference = new DTO\Reference();

        $reference->setMessageId(isset($refs->MsgId) ? (string) $refs->MsgId : null);
        $reference->setAccountServiceReference(isset($refs->AcctSvcrRef) ? (string) $refs->AcctSvcrRef : null);
        $reference->setPaymentInformationId(isset($refs->PmtInfId) ? (string) $refs->PmtInfId : null);
        $reference->setInstructionId(isset($refs->InstrId) ? (string) $refs->InstrId : null);
        $reference->setEndToEndId(isset($refs->EndToEndId) ? (string) $refs->EndToEndId : null);
        $reference->setTransactionId(isset($refs->TxId) ? (string) $refs->TxId : null);
        $reference->setMandateId(isset($refs->MndtId) ? (string) $refs->MndtId : null);
        $reference->setChequeNumber(isset($refs->ChqNb) ? (string) $refs->ChqNb : null);
        $reference->setClearingSystemReference(isset($refs->ClrSysRef) ? (string) $refs->ClrSysRef : null);
        $reference->setAccountOwnerTransactionId(isset($refs->AcctOwnrTxId) ? (string) $refs->AcctOwnrTxId : null);
        $reference->setAccountServicerTransactionId(isset($refs->AcctSvcrTxId) ? (string) $refs->AcctSvcrTxId : null);
        $reference->setMarketInfrastructureTransactionId(isset($refs->MktInfrstrctrTxId) ? (string) $refs->MktInfrstrctrTxId : null);
        $reference->setProcessingId(isset($refs->PrcgId) ? (string) $refs->PrcgId : null);

        foreach ($refs->Prtry as $xmlProprietary) {
            $type = isset($xmlProprietary->Tp) ? (string) $xmlProprietary->Tp : null;
            $subReference = isset($xmlProprietary->Ref) ? (string) $xmlProprietary->Ref : null;

            $reference->addProprietary(new DTO\ProprietaryReference($type, $subReference));
        }

        $detail->addReference($reference);
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
                $xmlRelatedPartyName = (isset($xmlRelatedPartyType->Nm)) ? (string) $xmlRelatedPartyType->Nm : '' ;
                $relatedPartyType = $creditor = new DTO\Creditor($xmlRelatedPartyName);

                $this->addRelatedParty($detail, $xmlRelatedPartyType, $relatedPartyType, $xmlRelatedPartyTypeAccount);
            }

            if (isset($xmlRelatedParty->UltmtCdtr)) {
                $xmlRelatedPartyType = $xmlRelatedParty->UltmtCdtr;
                $xmlRelatedPartyName = (isset($xmlRelatedPartyType->Nm)) ? (string) $xmlRelatedPartyType->Nm : '' ;
                $relatedPartyType = $creditor = new DTO\UltimateCreditor($xmlRelatedPartyName);

                $this->addRelatedParty($detail, $xmlRelatedPartyType, $relatedPartyType);
            }

            if (isset($xmlRelatedParty->Dbtr)) {
                $xmlRelatedPartyType = $xmlRelatedParty->Dbtr;
                $xmlRelatedPartyTypeAccount = $xmlRelatedParty->DbtrAcct;
                $xmlRelatedPartyName = (isset($xmlRelatedPartyType->Nm)) ? (string) $xmlRelatedPartyType->Nm : '' ;
                $relatedPartyType = $debtor = new DTO\Debtor($xmlRelatedPartyName);

                $this->addRelatedParty($detail, $xmlRelatedPartyType, $relatedPartyType, $xmlRelatedPartyTypeAccount);
            }

            if (isset($xmlRelatedParty->UltmtDbtr)) {
                $xmlRelatedPartyType = $xmlRelatedParty->UltmtDbtr;
                $xmlRelatedPartyName = (isset($xmlRelatedPartyType->Nm)) ? (string) $xmlRelatedPartyType->Nm : '' ;
                $relatedPartyType = $creditor = new DTO\UltimateDebtor($xmlRelatedPartyName);

                $this->addRelatedParty($detail, $xmlRelatedPartyType, $relatedPartyType);
            }
        }
    }

    /**
     * @param DTO\EntryTransactionDetail $detail
     * @param $xmlRelatedPartyType
     * @param $relatedPartyType
     * @param $xmlRelatedPartyTypeAccount
     * @return DTO\RelatedParty
     */
    protected function addRelatedParty(DTO\EntryTransactionDetail $detail, $xmlRelatedPartyType, DTO\RelatedPartyTypeInterface $relatedPartyType, $xmlRelatedPartyTypeAccount = null)
    {
        if (isset($xmlRelatedPartyType->PstlAdr)) {
            $relatedPartyType->setAddress(DTOFactory\Address::createFromXml($xmlRelatedPartyType->PstlAdr));
        }

        $relatedParty = new DTO\RelatedParty($relatedPartyType, $this->getRelatedPartyAccount($xmlRelatedPartyTypeAccount));

        $detail->addRelatedParty($relatedParty);

        return $relatedParty;
    }

    /**
     * @param DTO\EntryTransactionDetail $detail
     * @param SimpleXMLElement           $xmlDetail
     */
    public function addRelatedAgents(DTO\EntryTransactionDetail $detail, SimpleXMLElement $xmlDetail)
    {
        if (false === isset($xmlDetail->RltdAgts)) {
            return;
        }

        foreach ($xmlDetail->RltdAgts as $xmlRelatedAgent) {
            if (isset($xmlRelatedAgent->CdtrAgt)) {
                $agent = new DTO\CreditorAgent((string)$xmlRelatedAgent->CdtrAgt->FinInstnId->Nm, (string)$xmlRelatedAgent->CdtrAgt->FinInstnId->BIC);
                $relatedAgent =  new DTO\RelatedAgent($agent);
                $detail->addRelatedAgent($relatedAgent);
            }

            if (isset($xmlRelatedAgent->DbtrAgt)) {
                $agent = new DTO\DebtorAgent((string)$xmlRelatedAgent->DbtrAgt->FinInstnId->Nm, (string)$xmlRelatedAgent->DbtrAgt->FinInstnId->BIC);
                $relatedAgent =  new DTO\RelatedAgent($agent);
                $detail->addRelatedAgent($relatedAgent);
            }
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

        $remittanceInformation = new DTO\RemittanceInformation();
        $unstructuredBlockExists = false;

        // Unstructured blocks
        $xmlDetailsUnstructuredBlocks = $xmlDetail->RmtInf->Ustrd;
        if($xmlDetailsUnstructuredBlocks) {
            foreach($xmlDetailsUnstructuredBlocks as $xmlDetailsUnstructuredBlock) {
                $unstructuredRemittanceInformation = new DTO\UnstructuredRemittanceInformation(
                    (string)$xmlDetailsUnstructuredBlock
                );

                $remittanceInformation->addUnstructuredBlock($unstructuredRemittanceInformation);

                // Legacy : use the very first unstructured block
                if($remittanceInformation->getMessage() === null ) {
                    $unstructuredBlockExists = true;
                    $remittanceInformation->setMessage(
                        (string)$xmlDetailsUnstructuredBlock
                    );
                }
            }
        }

        // Strutcured blocks
        $xmlDetailsStructuredBlocks = $xmlDetail->RmtInf->Strd;
        if($xmlDetailsStructuredBlocks) {
            foreach($xmlDetailsStructuredBlocks as $xmlDetailsStructuredBlock) {
                $structuredRemittanceInformation = new DTO\StructuredRemittanceInformation();

                if(isset($xmlDetailsStructuredBlock->AddtlRmtInf)) {
                    $structuredRemittanceInformation->setAdditionalRemittanceInformation(
                        (string)$xmlDetailsStructuredBlock->AddtlRmtInf
                    );
                }

                if(isset($xmlDetailsStructuredBlock->CdtrRefInf)) {
                    $creditorReferenceInformation = new DTO\CreditorReferenceInformation();

                    if(isset($xmlDetailsStructuredBlock->CdtrRefInf->Ref)) {
                        $creditorReferenceInformation->setRef(
                            (string)$xmlDetailsStructuredBlock->CdtrRefInf->Ref
                        );
                    }

                    if(isset($xmlDetailsStructuredBlock->CdtrRefInf->Tp)
                            && isset($xmlDetailsStructuredBlock->CdtrRefInf->Tp->CdOrPrtry)
                            && isset($xmlDetailsStructuredBlock->CdtrRefInf->Tp->CdOrPrtry->Prtry)) {
                        $creditorReferenceInformation->setProprietary(
                            (string)$xmlDetailsStructuredBlock->CdtrRefInf->Tp->CdOrPrtry->Prtry
                        );
                    }

                    if(isset($xmlDetailsStructuredBlock->CdtrRefInf->Tp)
                            && isset($xmlDetailsStructuredBlock->CdtrRefInf->Tp->CdOrPrtry)
                            && isset($xmlDetailsStructuredBlock->CdtrRefInf->Tp->CdOrPrtry->Cd)) {
                        $creditorReferenceInformation->setCode(
                            (string)$xmlDetailsStructuredBlock->CdtrRefInf->Tp->CdOrPrtry->Cd
                        );
                    }

                    $structuredRemittanceInformation->setCreditorReferenceInformation($creditorReferenceInformation);

                    // Legacy : do not overwrite message if already defined above
                    // and no creditor reference is already defined
                    if(false === $unstructuredBlockExists
                            && $remittanceInformation->getCreditorReferenceInformation() === null) {
                        $remittanceInformation->setCreditorReferenceInformation($creditorReferenceInformation);
                    }
                }

                $remittanceInformation->addStructuredBlock($structuredRemittanceInformation);
            }
        }

        $detail->setRemittanceInformation($remittanceInformation);
    }

    /**
     * @param DTO\EntryTransactionDetail $detail
     * @param SimpleXMLElement           $xmlDetail
     */
    public function addRelatedDates(DTO\EntryTransactionDetail $detail, SimpleXMLElement $xmlDetail)
    {
        if (false === isset($xmlDetail->RltdDts)) {
            return;
        }

        if (isset($xmlDetail->RltdDts->AccptncDtTm)) {
            $RelatedDates = DTO\RelatedDates::fromUnstructured(
                $this->dateDecoder->decode((string) $xmlDetail->RltdDts->AccptncDtTm )
            );
            $detail->setRelatedDates($RelatedDates);
            return;
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

    /**
     * @param DTO\EntryTransactionDetail $detail
     * @param SimpleXMLElement           $xmlDetail
     */
    public function addBankTransactionCode(DTO\EntryTransactionDetail $detail, SimpleXMLElement $xmlDetail)
    {
        $bankTransactionCode = new DTO\BankTransactionCode();

        if (isset($xmlDetail->BkTxCd)) {
            $bankTransactionCode = new DTO\BankTransactionCode();

            if (isset($xmlDetail->BkTxCd->Prtry)) {
                $proprietaryBankTransactionCode = new DTO\ProprietaryBankTransactionCode(
                    (string)$xmlDetail->BkTxCd->Prtry->Cd,
                    (string)$xmlDetail->BkTxCd->Prtry->Issr
                );

                $bankTransactionCode->setProprietary($proprietaryBankTransactionCode);
            }

            if (isset($xmlDetail->BkTxCd->Domn)) {
                $domainBankTransactionCode = new DTO\DomainBankTransactionCode(
                    (string)$xmlDetail->BkTxCd->Domn->Cd
                );

                if (isset($xmlDetail->BkTxCd->Domn->Fmly)) {
                    $domainFamilyBankTransactionCode = new DTO\DomainFamilyBankTransactionCode(
                        (string)$xmlDetail->BkTxCd->Domn->Fmly->Cd,
                        (string)$xmlDetail->BkTxCd->Domn->Fmly->SubFmlyCd
                    );

                    $domainBankTransactionCode->setFamily($domainFamilyBankTransactionCode);
                }

                $bankTransactionCode->setDomain($domainBankTransactionCode);
            }
        }

        $detail->setBankTransactionCode($bankTransactionCode);
    }

    /**
     * @param DTO\EntryTransactionDetail $detail
     * @param SimpleXMLElement           $xmlDetail
     */
    public function addCharges(DTO\EntryTransactionDetail $detail, SimpleXMLElement $xmlDetail)
    {
            if (isset($xmlDetail->Chrgs)) {
                $charges = new DTO\Charges();

                if (isset($xmlDetail->Chrgs->TtlChrgsAndTaxAmt) && (string) $xmlDetail->Chrgs->TtlChrgsAndTaxAmt) {
                    $amount      = StringToUnits::convert((string) $xmlDetail->Chrgs->TtlChrgsAndTaxAmt);
                    $currency    = (string)$xmlDetail->Chrgs->TtlChrgsAndTaxAmt['Ccy'];

                    $charges->setTotalChargesAndTaxAmount(new Money($amount, new Currency($currency)));
                }

                $chargesRecords = $xmlDetail->Chrgs->Rcrd;
                if ($chargesRecords) {
                    foreach ($chargesRecords as $chargesRecord) {

                        $chargesDetail = new DTO\ChargesRecord();

                        if(isset($chargesRecord->Amt) && (string) $chargesRecord->Amt) {
                            $amount      = StringToUnits::convert((string) $chargesRecord->Amt);
                            $currency    = (string)$chargesRecord->Amt['Ccy'];

                            if ((string) $chargesRecord->CdtDbtInd === 'DBIT') {
                                $amount = $amount * -1;
                            }

                            $chargesDetail->setAmount(new Money($amount, new Currency($currency)));
                        }
                        if (isset($chargesRecord->CdtDbtInd) && (string) $chargesRecord->CdtDbtInd === 'true') {
                            $chargesDetail->setChargesIncluded­Indicator(true);
                        }
                        if (isset($chargesRecord->Tp->Prtry->Id) && (string) $chargesRecord->Tp->Prtry->Id) {
                            $chargesDetail->setIdentification((string) $chargesRecord->Tp->Prtry->Id);
                        }
                        $charges->addRecord($chargesDetail);
                    }
                }
                $detail->setCharges($charges);
            }
    }

    /**
     * @param DTO\EntryTransactionDetail $detail
     * @param SimpleXMLElement           $xmlDetail
     * @param SimpleXMLElement           $CdtDbtInd
     */
    public function addAmountDetails(DTO\EntryTransactionDetail $detail, SimpleXMLElement $xmlDetail, $CdtDbtInd)
    {
        if (isset($xmlDetail->AmtDtls)) {
            $amountDetails = new DTO\AmountDetails();

            if (isset($xmlDetail->AmtDtls->TxAmt) && isset($xmlDetail->AmtDtls->TxAmt->Amt)) {
                $amount = StringToUnits::convert((string) $xmlDetail->AmtDtls->TxAmt->Amt);

                if ((string) $CdtDbtInd === 'DBIT') {
                    $amount = $amount * -1;
                }

                $money = new Money(
                    $amount,
                    new Currency((string) $xmlDetail->AmtDtls->TxAmt->Amt['Ccy'])
                );
                $amountDetails->setAmount($money);
            }
            $detail->setAmountDetails($amountDetails);
        }
    }

    /**
     * @param DTO\EntryTransactionDetail $detail
     * @param SimpleXMLElement           $xmlDetail
     * @param SimpleXMLElement           $CdtDbtInd
     */
    public function addAmount(DTO\EntryTransactionDetail $detail, SimpleXMLElement $xmlDetail, $CdtDbtInd)
    {
        if (isset($xmlDetail->Amt)) {
            $amountDetails = new DTO\Amount();

                $amount = StringToUnits::convert((string) $xmlDetail->Amt);

                if ((string) $CdtDbtInd === 'DBIT') {
                    $amount = $amount * -1;
                }

                $money = new Money(
                    $amount,
                    new Currency((string) $xmlDetail->Amt['Ccy'])
                );
                $amountDetails->setAmount($money);

            $detail->setAmount($amountDetails);
        }
    }

    /**
     * @param SimpleXMLElement $xmlDetail
     *
     * @return DTO\Account|null
     */
    abstract public function getRelatedPartyAccount(SimpleXMLElement $xmlRelatedPartyTypeAccount = null);
}
