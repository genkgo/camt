<?php

declare(strict_types=1);

namespace Genkgo\Camt\Camt054\MessageFormat;

use Genkgo\Camt\Camt054;
use Genkgo\Camt\Decoder;
use Genkgo\Camt\DecoderInterface;
use Genkgo\Camt\MessageFormatInterface;

final class V08 implements MessageFormatInterface
{
    public function getXmlNs(): string
    {
        return 'urn:iso:std:iso:20022:tech:xsd:camt.054.001.08';
    }

    public function getMsgId(): string
    {
        return 'camt.054.001.08';
    }

    public function getName(): string
    {
        return 'BankToCustomerDebitCreditNotificationV08';
    }

    public function getDecoder(): DecoderInterface
    {
        $entryTransactionDetailDecoder = new Camt054\Decoder\EntryTransactionDetail(new Decoder\Date());
        $entryDecoder = new Decoder\Entry($entryTransactionDetailDecoder);
        $recordDecoder = new Decoder\Record($entryDecoder, new Decoder\Date());
        $messageDecoder = new Camt054\Decoder\V08\Message($recordDecoder, new Decoder\Date());

        return new Decoder($messageDecoder, sprintf('/assets/%s.xsd', $this->getMsgId()));
    }
}
