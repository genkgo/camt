<?php

declare(strict_types=1);

namespace Genkgo\Camt\Decoder;

use Genkgo\Camt\Decoder\Factory\DTO as DTOFactory;
use Genkgo\Camt\DTO;
use Genkgo\Camt\DTO\RelatedParty;
use Genkgo\Camt\Util\StringToUnits;
use Money\Currency;
use Money\Money;
use SimpleXMLElement;

abstract class EntryTransactionDetail
{
    /**
     * @var DateDecoderInterface
     */
    private $dateDecoder;

    /**
     * EntryTransactionDetail constructor.
     */
    public function __construct(DateDecoderInterface $dateDecoder)
    {
        $this->dateDecoder = $dateDecoder;
    }

    public function addReference(DTO\EntryTransactionDetail $detail, SimpleXMLElement $xmlDetail): void
    {
        if (false === isset($xmlDetail->Refs)) {
            return;
        }

        $refs = $xmlDetail->Refs;
        $reference = new DTO\Reference();

        $reference->setMessageId(isset($refs->MsgId) ? (string) $refs->MsgId : null);
        $reference->setAccountServicerReference(isset($refs->AcctSvcrRef) ? (string) $refs->AcctSvcrRef : null);
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

        $detail->setReference($reference);
    }

    public function addRelatedParties(DTO\EntryTransactionDetail $detail, SimpleXMLElement $xmlDetail): void
    {
        if (false === isset($xmlDetail->RltdPties)) {
            return;
        }

        /** @var SimpleXMLElement $xmlRelatedParty */
        foreach ($xmlDetail->RltdPties as $xmlRelatedParty) {
            if (isset($xmlRelatedParty->Cdtr)) {
                $xmlRelatedPartyType = $xmlRelatedParty->Cdtr;
                $xmlRelatedPartyTypeAccount = $xmlRelatedParty->CdtrAcct;
                $xmlRelatedPartyName = (isset($xmlRelatedPartyType->Nm)) ? (string) $xmlRelatedPartyType->Nm : '';
                $relatedPartyType = new DTO\Creditor($xmlRelatedPartyName);

                $this->addRelatedParty($detail, $xmlRelatedPartyType, $relatedPartyType, $xmlRelatedPartyTypeAccount);
            }

            if (isset($xmlRelatedParty->UltmtCdtr)) {
                $xmlRelatedPartyType = $xmlRelatedParty->UltmtCdtr;
                $xmlRelatedPartyName = (isset($xmlRelatedPartyType->Nm)) ? (string) $xmlRelatedPartyType->Nm : '';
                $relatedPartyType = new DTO\UltimateCreditor($xmlRelatedPartyName);

                $this->addRelatedParty($detail, $xmlRelatedPartyType, $relatedPartyType);
            }

            if (isset($xmlRelatedParty->Dbtr)) {
                $xmlRelatedPartyType = $xmlRelatedParty->Dbtr;
                $xmlRelatedPartyTypeAccount = $xmlRelatedParty->DbtrAcct;
                $xmlRelatedPartyName = (isset($xmlRelatedPartyType->Nm)) ? (string) $xmlRelatedPartyType->Nm : '';
                $relatedPartyType = $debtor = new DTO\Debtor($xmlRelatedPartyName);

                $this->addRelatedParty($detail, $xmlRelatedPartyType, $relatedPartyType, $xmlRelatedPartyTypeAccount);
            }

            if (isset($xmlRelatedParty->UltmtDbtr)) {
                $xmlRelatedPartyType = $xmlRelatedParty->UltmtDbtr;
                $xmlRelatedPartyName = (isset($xmlRelatedPartyType->Nm)) ? (string) $xmlRelatedPartyType->Nm : '';
                $relatedPartyType = new DTO\UltimateDebtor($xmlRelatedPartyName);

                $this->addRelatedParty($detail, $xmlRelatedPartyType, $relatedPartyType);
            }
        }
    }

    protected function addRelatedParty(DTO\EntryTransactionDetail $detail, SimpleXMLElement $xmlRelatedPartyType, DTO\RelatedPartyTypeInterface $relatedPartyType, ?SimpleXMLElement $xmlRelatedPartyTypeAccount = null): RelatedParty
    {
        if (isset($xmlRelatedPartyType->PstlAdr)) {
            $relatedPartyType->setAddress(DTOFactory\Address::createFromXml($xmlRelatedPartyType->PstlAdr));
        }

        $relatedParty = new RelatedParty($relatedPartyType, $this->getRelatedPartyAccount($xmlRelatedPartyTypeAccount));

        $detail->addRelatedParty($relatedParty);

        return $relatedParty;
    }

    public function addRelatedAgents(DTO\EntryTransactionDetail $detail, SimpleXMLElement $xmlDetail): void
    {
        if (false === isset($xmlDetail->RltdAgts)) {
            return;
        }

        foreach ($xmlDetail->RltdAgts as $xmlRelatedAgent) {
            if (isset($xmlRelatedAgent->CdtrAgt)) {
                $agent = new DTO\CreditorAgent((string) $xmlRelatedAgent->CdtrAgt->FinInstnId->Nm, (string) $xmlRelatedAgent->CdtrAgt->FinInstnId->BIC);
                $relatedAgent = new DTO\RelatedAgent($agent);
                $detail->addRelatedAgent($relatedAgent);
            }

            if (isset($xmlRelatedAgent->DbtrAgt)) {
                $agent = new DTO\DebtorAgent((string) $xmlRelatedAgent->DbtrAgt->FinInstnId->Nm, (string) $xmlRelatedAgent->DbtrAgt->FinInstnId->BIC);
                $relatedAgent = new DTO\RelatedAgent($agent);
                $detail->addRelatedAgent($relatedAgent);
            }
        }
    }

    public function addRemittanceInformation(DTO\EntryTransactionDetail $detail, SimpleXMLElement $xmlDetail): void
    {
        if (false === isset($xmlDetail->RmtInf)) {
            return;
        }

        $remittanceInformation = new DTO\RemittanceInformation();
        $unstructuredBlockExists = false;

        // Unstructured blocks
        $xmlDetailsUnstructuredBlocks = $xmlDetail->RmtInf->Ustrd;
        if ($xmlDetailsUnstructuredBlocks !== null) {
            foreach ($xmlDetailsUnstructuredBlocks as $xmlDetailsUnstructuredBlock) {
                $unstructuredRemittanceInformation = new DTO\UnstructuredRemittanceInformation(
                    (string) $xmlDetailsUnstructuredBlock
                );

                $remittanceInformation->addUnstructuredBlock($unstructuredRemittanceInformation);

                // Legacy : use the very first unstructured block
                if ($remittanceInformation->getMessage() === null) {
                    $unstructuredBlockExists = true;
                    $remittanceInformation->setMessage(
                        (string) $xmlDetailsUnstructuredBlock
                    );
                }
            }
        }

        // Strutcured blocks
        $xmlDetailsStructuredBlocks = $xmlDetail->RmtInf->Strd;
        if ($xmlDetailsStructuredBlocks !== null) {
            foreach ($xmlDetailsStructuredBlocks as $xmlDetailsStructuredBlock) {
                $structuredRemittanceInformation = new DTO\StructuredRemittanceInformation();

                if (isset($xmlDetailsStructuredBlock->AddtlRmtInf)) {
                    $structuredRemittanceInformation->setAdditionalRemittanceInformation(
                        (string) $xmlDetailsStructuredBlock->AddtlRmtInf
                    );
                }

                if (isset($xmlDetailsStructuredBlock->CdtrRefInf)) {
                    $creditorReferenceInformation = new DTO\CreditorReferenceInformation();

                    if (isset($xmlDetailsStructuredBlock->CdtrRefInf->Ref)) {
                        $creditorReferenceInformation->setRef(
                            (string) $xmlDetailsStructuredBlock->CdtrRefInf->Ref
                        );
                    }

                    if (isset($xmlDetailsStructuredBlock->CdtrRefInf->Tp, $xmlDetailsStructuredBlock->CdtrRefInf->Tp->CdOrPrtry, $xmlDetailsStructuredBlock->CdtrRefInf->Tp->CdOrPrtry->Prtry)

                         ) {
                        $creditorReferenceInformation->setProprietary(
                            (string) $xmlDetailsStructuredBlock->CdtrRefInf->Tp->CdOrPrtry->Prtry
                        );
                    }

                    if (isset($xmlDetailsStructuredBlock->CdtrRefInf->Tp, $xmlDetailsStructuredBlock->CdtrRefInf->Tp->CdOrPrtry, $xmlDetailsStructuredBlock->CdtrRefInf->Tp->CdOrPrtry->Cd)

                         ) {
                        $creditorReferenceInformation->setCode(
                            (string) $xmlDetailsStructuredBlock->CdtrRefInf->Tp->CdOrPrtry->Cd
                        );
                    }

                    $structuredRemittanceInformation->setCreditorReferenceInformation($creditorReferenceInformation);

                    // Legacy : do not overwrite message if already defined above
                    // and no creditor reference is already defined
                    if (false === $unstructuredBlockExists
                        && $remittanceInformation->getCreditorReferenceInformation() === null) {
                        $remittanceInformation->setCreditorReferenceInformation($creditorReferenceInformation);
                    }
                }

                $remittanceInformation->addStructuredBlock($structuredRemittanceInformation);
            }
        }

        $detail->setRemittanceInformation($remittanceInformation);
    }

    public function addRelatedDates(DTO\EntryTransactionDetail $detail, SimpleXMLElement $xmlDetail): void
    {
        if (false === isset($xmlDetail->RltdDts)) {
            return;
        }

        if (isset($xmlDetail->RltdDts->AccptncDtTm)) {
            $RelatedDates = DTO\RelatedDates::fromUnstructured(
                $this->dateDecoder->decode((string) $xmlDetail->RltdDts->AccptncDtTm)
            );
            $detail->setRelatedDates($RelatedDates);

            return;
        }
    }

    public function addReturnInformation(DTO\EntryTransactionDetail $detail, SimpleXMLElement $xmlDetail): void
    {
        if (isset($xmlDetail->RtrInf, $xmlDetail->RtrInf->Rsn->Cd)) {
            $remittanceInformation = DTO\ReturnInformation::fromUnstructured(
                (string) $xmlDetail->RtrInf->Rsn->Cd,
                (string) $xmlDetail->RtrInf->AddtlInf
            );
            $detail->setReturnInformation($remittanceInformation);
        }
    }

    public function addAdditionalTransactionInformation(DTO\EntryTransactionDetail $detail, SimpleXMLElement $xmlDetail): void
    {
        if (isset($xmlDetail->AddtlTxInf)) {
            $additionalInformation = new DTO\AdditionalTransactionInformation(
                (string) $xmlDetail->AddtlTxInf
            );
            $detail->setAdditionalTransactionInformation($additionalInformation);
        }
    }

    public function addBankTransactionCode(DTO\EntryTransactionDetail $detail, SimpleXMLElement $xmlDetail): void
    {
        $bankTransactionCode = new DTO\BankTransactionCode();

        if (isset($xmlDetail->BkTxCd)) {
            $bankTransactionCode = new DTO\BankTransactionCode();

            if (isset($xmlDetail->BkTxCd->Prtry)) {
                $proprietaryBankTransactionCode = new DTO\ProprietaryBankTransactionCode(
                    (string) $xmlDetail->BkTxCd->Prtry->Cd,
                    (string) $xmlDetail->BkTxCd->Prtry->Issr
                );

                $bankTransactionCode->setProprietary($proprietaryBankTransactionCode);
            }

            if (isset($xmlDetail->BkTxCd->Domn)) {
                $domainBankTransactionCode = new DTO\DomainBankTransactionCode(
                    (string) $xmlDetail->BkTxCd->Domn->Cd
                );

                if (isset($xmlDetail->BkTxCd->Domn->Fmly)) {
                    $domainFamilyBankTransactionCode = new DTO\DomainFamilyBankTransactionCode(
                        (string) $xmlDetail->BkTxCd->Domn->Fmly->Cd,
                        (string) $xmlDetail->BkTxCd->Domn->Fmly->SubFmlyCd
                    );

                    $domainBankTransactionCode->setFamily($domainFamilyBankTransactionCode);
                }

                $bankTransactionCode->setDomain($domainBankTransactionCode);
            }
        }

        $detail->setBankTransactionCode($bankTransactionCode);
    }

    public function addCharges(DTO\EntryTransactionDetail $detail, SimpleXMLElement $xmlDetail): void
    {
        if (isset($xmlDetail->Chrgs)) {
            $charges = new DTO\Charges();

            if (isset($xmlDetail->Chrgs->TtlChrgsAndTaxAmt) && (string) $xmlDetail->Chrgs->TtlChrgsAndTaxAmt) {
                $amount = StringToUnits::convert((string) $xmlDetail->Chrgs->TtlChrgsAndTaxAmt);
                $currency = (string) $xmlDetail->Chrgs->TtlChrgsAndTaxAmt['Ccy'];

                $charges->setTotalChargesAndTaxAmount(new Money($amount, new Currency($currency)));
            }

            $chargesRecords = $xmlDetail->Chrgs->Rcrd;
            if ($chargesRecords !== null) {

                /** @var SimpleXMLElement $chargesRecord */
                foreach ($chargesRecords as $chargesRecord) {
                    $chargesDetail = new DTO\ChargesRecord();

                    if (isset($chargesRecord->Amt) && (string) $chargesRecord->Amt) {
                        $amount = StringToUnits::convert((string) $chargesRecord->Amt);
                        $currency = (string) $chargesRecord->Amt['Ccy'];

                        if ((string) $chargesRecord->CdtDbtInd === 'DBIT') {
                            $amount = $amount * -1;
                        }

                        $chargesDetail->setAmount(new Money($amount, new Currency($currency)));
                    }
                    if (isset($chargesRecord->CdtDbtInd) && (string) $chargesRecord->CdtDbtInd === 'true') {
                        $chargesDetail->setChargesIncludedIndicator(true);
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

    public function addAmountDetails(DTO\EntryTransactionDetail $detail, SimpleXMLElement $xmlDetail, SimpleXMLElement $CdtDbtInd): void
    {
        if (isset($xmlDetail->AmtDtls, $xmlDetail->AmtDtls->TxAmt, $xmlDetail->AmtDtls->TxAmt->Amt)) {
            $money = $this->createMoney($xmlDetail->AmtDtls->TxAmt->Amt, $CdtDbtInd);
            $detail->setAmountDetails($money);
        }
    }

    public function addAmount(DTO\EntryTransactionDetail $detail, SimpleXMLElement $xmlDetail, SimpleXMLElement $CdtDbtInd): void
    {
        if (isset($xmlDetail->Amt)) {
            $money = $this->createMoney($xmlDetail->Amt, $CdtDbtInd);
            $detail->setAmount($money);
        }
    }

    private function createMoney(SimpleXMLElement $xmlAmount, SimpleXMLElement $CdtDbtInd): Money
    {
        $amount = StringToUnits::convert((string) $xmlAmount);

        if ((string) $CdtDbtInd === 'DBIT') {
            $amount = $amount * -1;
        }

        return new Money(
            $amount,
            new Currency((string) $xmlAmount['Ccy'])
        );
    }

    abstract public function getRelatedPartyAccount(?SimpleXMLElement $xmlRelatedPartyTypeAccount): ?DTO\Account;
}
