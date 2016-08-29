<?php

namespace Genkgo\Camt\Decoder;

use Genkgo\Camt\DTO;
use Genkgo\Camt\Util\StringToUnits;
use Money\Money;
use Money\Currency;
use \SimpleXMLElement;
use \DateTimeImmutable;

class Record
{
    /**
     * @var Entry
     */
    private $entryDecoder;

    public function __construct(Entry $entryDecoder)
    {
        $this->entryDecoder = $entryDecoder;
    }

    /**
     * @param DTO\Record       $record
     * @param SimpleXMLElement $xmlRecord
     */
    public function addBalances(DTO\Record $record, SimpleXMLElement $xmlRecord)
    {
        $xmlBalances = $xmlRecord->Bal;
        foreach ($xmlBalances as $xmlBalance) {
            $amount = StringToUnits::convert((string) $xmlBalance->Amt);
            $currency = (string)$xmlBalance->Amt['Ccy'];
            $date = (string)$xmlBalance->Dt->Dt;

            if ((string) $xmlBalance->CdtDbtInd === 'DBIT') {
                $amount = $amount * -1;
            }

            if (isset($xmlBalance->Tp)
                && isset($xmlBalance->Tp->CdOrPrtry)
                && (string) $xmlBalance->Tp->CdOrPrtry->Cd === 'OPBD'
            ) {
                $balance = DTO\Balance::opening(
                    new Money(
                        $amount,
                        new Currency($currency)
                    ),
                    new DateTimeImmutable($date)
                );
            } else {
                $balance = DTO\Balance::closing(
                    new Money(
                        $amount,
                        new Currency($currency)
                    ),
                    new DateTimeImmutable($date)
                );
            }

            $record->addBalance($balance);
        }
    }

    /**
     * @param DTO\Record       $record
     * @param SimpleXMLElement $xmlRecord
     */
    public function addEntries(DTO\Record $record, SimpleXMLElement $xmlRecord)
    {
        $index = 0;
        $xmlEntries = $xmlRecord->Ntry;
        foreach ($xmlEntries as $xmlEntry) {
            $amount      = StringToUnits::convert((string) $xmlEntry->Amt);
            $currency    = (string)$xmlEntry->Amt['Ccy'];
            $bookingDate = ((string) $xmlEntry->BookgDt->Dt) ?: (string) $xmlEntry->BookgDt->DtTm;
            $valueDate   = ((string) $xmlEntry->ValDt->Dt) ?: (string) $xmlEntry->ValDt->DtTm;
            $additionalInfo = ((string) $xmlEntry->AddtlNtryInf) ?: (string) $xmlEntry->AddtlNtryInf;

            if ((string) $xmlEntry->CdtDbtInd === 'DBIT') {
                $amount = $amount * -1;
            }

            $entry = new DTO\Entry(
                $record,
                $index,
                new Money($amount, new Currency($currency)),
                new DateTimeImmutable($bookingDate),
                new DateTimeImmutable($valueDate),
                $additionalInfo
            );

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


            if(isset($xmlEntry->BkTxCd)) {
                $bankTransactionCode = new DTO\BankTransactionCode();

                if(isset($xmlEntry->BkTxCd->Prtry)) {
                    $proprietaryBankTransactionCode = new DTO\ProprietaryBankTransactionCode(
                        (string)$xmlEntry->BkTxCd->Prtry->Cd,
                        (string)$xmlEntry->BkTxCd->Prtry->Issr
                    );

                    $bankTransactionCode->setProprietary($proprietaryBankTransactionCode);
                }

                $entry->setBankTransactionCode($bankTransactionCode);
            }

            $this->entryDecoder->addTransactionDetails($entry, $xmlEntry);

            $record->addEntry($entry);
            $index++;
        }
    }
}
