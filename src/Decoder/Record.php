<?php

declare(strict_types=1);

namespace Genkgo\Camt\Decoder;

use Genkgo\Camt\DTO;
use Genkgo\Camt\DTO\RecordWithBalances;
use Genkgo\Camt\Util\StringToUnits;
use Money\Currency;
use Money\Money;
use SimpleXMLElement;

class Record
{
    /**
     * @var Entry
     */
    private $entryDecoder;

    /**
     * @var DateDecoderInterface
     */
    private $dateDecoder;

    /**
     * Record constructor.
     */
    public function __construct(Entry $entryDecoder, DateDecoderInterface $dateDecoder)
    {
        $this->entryDecoder = $entryDecoder;
        $this->dateDecoder = $dateDecoder;
    }

    public function addBalances(RecordWithBalances $record, SimpleXMLElement $xmlRecord): void
    {
        $xmlBalances = $xmlRecord->Bal;
        foreach ($xmlBalances as $xmlBalance) {
            $amount = StringToUnits::convert((string) $xmlBalance->Amt);
            $currency = (string) $xmlBalance->Amt['Ccy'];
            $date = (string) $xmlBalance->Dt->Dt;

            if ((string) $xmlBalance->CdtDbtInd === 'DBIT') {
                $amount = $amount * -1;
            }

            if (isset($xmlBalance->Tp, $xmlBalance->Tp->CdOrPrtry)) {
                $code = (string) $xmlBalance->Tp->CdOrPrtry->Cd;

                if (in_array($code, ['OPBD', 'PRCD'], true)) {
                    $record->addBalance(DTO\Balance::opening(
                        new Money(
                            $amount,
                            new Currency($currency)
                        ),
                        $this->dateDecoder->decode($date)
                    ));
                } elseif ($code === 'CLBD') {
                    $record->addBalance(DTO\Balance::closing(
                        new Money(
                            $amount,
                            new Currency($currency)
                        ),
                        $this->dateDecoder->decode($date)
                    ));
                }
            }
        }
    }

    public function addEntries(DTO\Record $record, SimpleXMLElement $xmlRecord): void
    {
        $index = 0;
        $xmlEntries = $xmlRecord->Ntry;
        foreach ($xmlEntries as $xmlEntry) {
            $amount = StringToUnits::convert((string) $xmlEntry->Amt);
            $currency = (string) $xmlEntry->Amt['Ccy'];
            $bookingDate = ((string) $xmlEntry->BookgDt->Dt) ?: (string) $xmlEntry->BookgDt->DtTm;
            $valueDate = ((string) $xmlEntry->ValDt->Dt) ?: (string) $xmlEntry->ValDt->DtTm;
            $additionalInfo = ((string) $xmlEntry->AddtlNtryInf) ?: (string) $xmlEntry->AddtlNtryInf;

            if ((string) $xmlEntry->CdtDbtInd === 'DBIT') {
                $amount = $amount * -1;
            }

            $entry = new DTO\Entry(
                $record,
                $index,
                new Money($amount, new Currency($currency))
            );

            if ($bookingDate) {
                $entry->setBookingDate($this->dateDecoder->decode($bookingDate));
            }

            if ($valueDate) {
                $entry->setValueDate($this->dateDecoder->decode($valueDate));
            }

            $entry->setAdditionalInfo($additionalInfo);

            if (isset($xmlEntry->RvslInd) && (string) $xmlEntry->RvslInd === 'true') {
                $entry->setReversalIndicator(true);
            }

            if (isset($xmlEntry->NtryRef) && (string) $xmlEntry->NtryRef) {
                $entry->setReference((string) $xmlEntry->NtryRef);
            }

            if (isset($xmlEntry->AcctSvcrRef) && (string) $xmlEntry->AcctSvcrRef) {
                $entry->setAccountServicerReference((string) $xmlEntry->AcctSvcrRef);
            }

            if (isset($xmlEntry->NtryDtls->Btch->PmtInfId) && (string) $xmlEntry->NtryDtls->Btch->PmtInfId) {
                $entry->setBatchPaymentId((string) $xmlEntry->NtryDtls->Btch->PmtInfId);
            }

            if (isset($xmlEntry->NtryDtls->TxDtls->Refs->PmtInfId) && (string) $xmlEntry->NtryDtls->TxDtls->Refs->PmtInfId) {
                $entry->setBatchPaymentId((string) $xmlEntry->NtryDtls->TxDtls->Refs->PmtInfId);
            }

            if (isset($xmlEntry->BkTxCd)) {
                $bankTransactionCode = new DTO\BankTransactionCode();

                if (isset($xmlEntry->BkTxCd->Prtry)) {
                    $proprietaryBankTransactionCode = new DTO\ProprietaryBankTransactionCode(
                        (string) $xmlEntry->BkTxCd->Prtry->Cd,
                        (string) $xmlEntry->BkTxCd->Prtry->Issr
                    );

                    $bankTransactionCode->setProprietary($proprietaryBankTransactionCode);
                }

                if (isset($xmlEntry->BkTxCd->Domn)) {
                    $domainBankTransactionCode = new DTO\DomainBankTransactionCode(
                        (string) $xmlEntry->BkTxCd->Domn->Cd
                    );

                    if (isset($xmlEntry->BkTxCd->Domn->Fmly)) {
                        $domainFamilyBankTransactionCode = new DTO\DomainFamilyBankTransactionCode(
                            (string) $xmlEntry->BkTxCd->Domn->Fmly->Cd,
                            (string) $xmlEntry->BkTxCd->Domn->Fmly->SubFmlyCd
                        );

                        $domainBankTransactionCode->setFamily($domainFamilyBankTransactionCode);
                    }

                    $bankTransactionCode->setDomain($domainBankTransactionCode);
                }

                $entry->setBankTransactionCode($bankTransactionCode);
            }

            if (isset($xmlEntry->Chrgs)) {
                $charges = new DTO\Charges();

                if (isset($xmlEntry->Chrgs->TtlChrgsAndTaxAmt) && (string) $xmlEntry->Chrgs->TtlChrgsAndTaxAmt) {
                    $amount = StringToUnits::convert((string) $xmlEntry->Chrgs->TtlChrgsAndTaxAmt);
                    $currency = (string) $xmlEntry->Chrgs->TtlChrgsAndTaxAmt['Ccy'];

                    $charges->setTotalChargesAndTaxAmount(new Money($amount, new Currency($currency)));
                }

                $chargesRecords = $xmlEntry->Chrgs->Rcrd;
                if ($chargesRecords) {

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
                $entry->setCharges($charges);
            }

            $this->entryDecoder->addTransactionDetails($entry, $xmlEntry);

            $record->addEntry($entry);
            ++$index;
        }
    }
}
