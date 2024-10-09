<?php

declare(strict_types=1);

namespace Genkgo\Camt\Camt053\MessageFormat;

use Genkgo\Camt\Camt053;
use Genkgo\Camt\Decoder;
use Genkgo\Camt\DecoderInterface;
use Genkgo\Camt\MessageFormatInterface;

final class V04 implements MessageFormatInterface
{
    public function getXmlNs(): string
    {
        return 'urn:iso:std:iso:20022:tech:xsd:camt.053.001.04';
    }

    public function getMsgId(): string
    {
        return 'camt.053.001.04';
    }

    public function getName(): string
    {
        return 'BankToCustomerStatementV04';
    }

    public function getDecoder(): DecoderInterface
    {
        $entryTransactionDetailDecoder = new Camt053\Decoder\EntryTransactionDetail(new Decoder\Date());
        $entryDecoder = new Decoder\Entry($entryTransactionDetailDecoder);
        $recordDecoder = new Decoder\Record($entryDecoder, new Decoder\Date());
        $messageDecoder = new Camt053\Decoder\Message($recordDecoder, new Decoder\Date());

        return new Decoder($messageDecoder, sprintf('/assets/%s.xsd', $this->getMsgId()));
    }
}
