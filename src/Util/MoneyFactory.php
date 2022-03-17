<?php

declare(strict_types=1);

namespace Genkgo\Camt\Util;

use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Money;
use Money\Parser\DecimalMoneyParser;
use SimpleXMLElement;

final class MoneyFactory
{
    private DecimalMoneyParser $decimalMoneyParser;

    public function __construct()
    {
        $this->decimalMoneyParser = new DecimalMoneyParser(new ISOCurrencies());
    }

    public function create(SimpleXMLElement $xmlAmount, ?SimpleXMLElement $CdtDbtInd): Money
    {
        $amount = (string) $xmlAmount;

        if ((string) $CdtDbtInd === 'DBIT') {
            $amount = (string) ((float) $amount * -1);
        }

        /** @psalm-var non-empty-string $currency */
        $currency = (string) $xmlAmount['Ccy'];

        return $this->decimalMoneyParser->parse(
            $amount,
            new Currency($currency)
        );
    }
}
