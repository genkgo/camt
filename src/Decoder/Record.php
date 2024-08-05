<?php

declare(strict_types=1);

namespace Genkgo\Camt\Decoder;

use Genkgo\Camt\DTO;
use Genkgo\Camt\DTO\RecordWithBalances;
use Genkgo\Camt\Util\MoneyFactory;
use SimpleXMLElement;

class Record
{
    private Entry $entryDecoder;

    private DateDecoderInterface $dateDecoder;

    private MoneyFactory $moneyFactory;

    /**
     * Record constructor.
     */
    public function __construct(Entry $entryDecoder, DateDecoderInterface $dateDecoder)
    {
        $this->entryDecoder = $entryDecoder;
        $this->dateDecoder = $dateDecoder;
        $this->moneyFactory = new MoneyFactory();
    }

    public function addBalances(RecordWithBalances $record, SimpleXMLElement $xmlRecord): void
    {
        $xmlBalances = $xmlRecord->Bal;
        foreach ($xmlBalances as $xmlBalance) {
            $money = $this->moneyFactory->create($xmlBalance->Amt, $xmlBalance->CdtDbtInd);
            $date = $this->dateDecoder->decode((string) $xmlBalance->Dt->Dt);

            if (!isset($xmlBalance->Tp, $xmlBalance->Tp->CdOrPrtry)) {
                continue;
            }
            $code = (string) $xmlBalance->Tp->CdOrPrtry->Cd;

            switch ($code) {
                case 'OPBD':
                case 'PRCD':
                    $record->addBalance(DTO\Balance::opening(
                        $money,
                        $date
                    ));

                    break;
                case 'OPAV':
                    $record->addBalance(DTO\Balance::openingAvailable(
                        $money,
                        $date
                    ));

                    break;
                case 'CLBD':
                    $record->addBalance(DTO\Balance::closing(
                        $money,
                        $date
                    ));

                    break;
                case 'CLAV':
                    $record->addBalance(DTO\Balance::closingAvailable(
                        $money,
                        $date
                    ));

                    break;
                case 'FWAV':
                    $record->addBalance(DTO\Balance::forwardAvailable(
                        $money,
                        $date
                    ));

                    break;
                case 'INFO':
                    $record->addBalance(DTO\Balance::information(
                        $money,
                        $date
                    ));

                    break;
                case 'ITAV':
                    $record->addBalance(DTO\Balance::interimAvailable(
                        $money,
                        $date
                    ));

                    break;
                case 'ITBD':
                    $record->addBalance(DTO\Balance::interim(
                        $money,
                        $date
                    ));

                    break;

                case 'XPCD':
                    $record->addBalance(DTO\Balance::expectedCredit(
                        $money,
                        $date
                    ));

                    break;
                default:
                    break;
            }
        }
    }

    public function addEntries(DTO\Record $record, SimpleXMLElement $xmlRecord): void
    {
        $index = 0;
        $xmlEntries = $xmlRecord->Ntry;
        foreach ($xmlEntries as $xmlEntry) {
            $money = $this->moneyFactory->create($xmlEntry->Amt, $xmlEntry->CdtDbtInd);
            $bookingDate = ((string) $xmlEntry->BookgDt->Dt) ?: (string) $xmlEntry->BookgDt->DtTm;
            $valueDate = ((string) $xmlEntry->ValDt->Dt) ?: (string) $xmlEntry->ValDt->DtTm;
            $additionalInfo = ((string) $xmlEntry->AddtlNtryInf) ?: (string) $xmlEntry->AddtlNtryInf;

            $entry = new DTO\Entry(
                $record,
                $index,
                $money
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

            if (isset($xmlEntry->CdtDbtInd) && in_array((string) $xmlEntry->CdtDbtInd, ['CRDT', 'DBIT'], true)) {
                $entry->setCreditDebitIndicator((string) $xmlEntry->CdtDbtInd);
            }

            $entry->setStatus($this->readStatus($xmlEntry));

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
                    $money = $this->moneyFactory->create($xmlEntry->Chrgs->TtlChrgsAndTaxAmt, null);
                    $charges->setTotalChargesAndTaxAmount($money);
                }

                $chargesRecords = $xmlEntry->Chrgs->Rcrd;
                if ($chargesRecords) {
                    /** @var SimpleXMLElement $chargesRecord */
                    foreach ($chargesRecords as $chargesRecord) {
                        $chargesDetail = new DTO\ChargesRecord();

                        if (isset($chargesRecord->Amt) && (string) $chargesRecord->Amt) {
                            $money = $this->moneyFactory->create($chargesRecord->Amt, $chargesRecord->CdtDbtInd);

                            $chargesDetail->setAmount($money);
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

    private function readStatus(SimpleXMLElement $xmlEntry): ?string
    {
        $xmlStatus = $xmlEntry->Sts;

        // CAMT v08 uses substructure, so we check for its existence or fallback to the element itself to keep compatibility with CAMT v04
        return (string) $xmlStatus?->Cd
            ?: (string) $xmlStatus?->Prtry
                ?: (string) $xmlStatus
                    ?: null;
    }
}
