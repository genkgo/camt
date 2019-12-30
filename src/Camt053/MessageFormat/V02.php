<?php

namespace Genkgo\Camt\Camt053\MessageFormat;

use Genkgo\Camt\Camt053;
use Genkgo\Camt\Decoder;
use Genkgo\Camt\DecoderInterface;
use Genkgo\Camt\MessageFormatInterface;

/**
 * Class MessageFormat
 * @package Genkgo\Camt\Camt053
 */
final class V02 implements MessageFormatInterface
{
    /**
     * @return string
     */
    public function getXmlNs(): string
    {
        return 'urn:iso:std:iso:20022:tech:xsd:camt.053.001.02';
    }

    /**
     * @return string
     */
    public function getMsgId(): string
    {
        return 'camt.053.001.02';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'BankToCustomerStatementV02';
    }

    /**
     * @return DecoderInterface
     */
    public function getDecoder(): DecoderInterface
    {
        $entryTransactionDetailDecoder = new Camt053\Decoder\EntryTransactionDetail(new Decoder\Date());
        $entryDecoder                  = new Decoder\Entry($entryTransactionDetailDecoder);
        $recordDecoder                 = new Decoder\Record($entryDecoder, new Decoder\Date());
        $messageDecoder                = new Camt053\Decoder\Message($recordDecoder, new Decoder\Date());

        return new Decoder($messageDecoder, sprintf('/assets/%s.xsd', $this->getMsgId()));
    }
}
