<?php

namespace Genkgo\Camt\Camt053\Decoder;

use Genkgo\Camt\Camt053\DTO;
use Genkgo\Camt\Util\StringToUnits;
use Money\Money;
use Money\Currency;
use \SimpleXMLElement;
use \DateTimeImmutable;

class Statement
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
     * @param DTO\Statement    $statement
     * @param SimpleXMLElement $xmlStatement
     */
    public function addBalances(DTO\Statement $statement, SimpleXMLElement $xmlStatement)
    {
        $xmlBalances = $xmlStatement->Bal;
        foreach ($xmlBalances as $xmlBalance) {
            $amount = StringToUnits::convert((string) $xmlBalance->Amt);
            $currency = (string)$xmlBalance->Amt['Ccy'];
            $date = (string)$xmlBalance->Dt->Dt;

            if ((string) $xmlBalance->CdtDbtInd === 'DBIT') {
                $amount = $amount * -1;
            }

            if ((string) $xmlBalance->Tp->CdOrPrtry->Cd === 'OPBD') {
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

            $statement->addBalance($balance);
        }
    }

    /**
     * @param DTO\Statement    $statement
     * @param SimpleXMLElement $xmlStatement
     */
    public function addEntries(DTO\Statement $statement, SimpleXMLElement $xmlStatement)
    {
        $index = 0;
        $xmlEntries = $xmlStatement->Ntry;
        foreach ($xmlEntries as $xmlEntry) {
            $amount = StringToUnits::convert((string) $xmlEntry->Amt);
            $currency = (string)$xmlEntry->Amt['Ccy'];
            $bookingDate = (string)$xmlEntry->BookgDt->Dt;
            $valueDate = (string)$xmlEntry->ValDt->Dt;

            if ((string) $xmlEntry->CdtDbtInd === 'DBIT') {
                $amount = $amount * -1;
            }

            $entry = new DTO\Entry(
                $statement,
                $index,
                new Money($amount, new Currency($currency)),
                new DateTimeImmutable($bookingDate),
                new DateTimeImmutable($valueDate)
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

            $this->entryDecoder->addTransactionDetails($entry, $xmlEntry);

            $statement->addEntry($entry);
            $index++;
        }
    }
}
