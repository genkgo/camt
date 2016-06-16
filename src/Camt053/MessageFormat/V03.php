<?php

namespace Genkgo\Camt\Camt053\MessageFormat;

use Genkgo\Camt\Camt053;
use Genkgo\Camt\Decoder;
use Genkgo\Camt\DecoderInterface;
use Genkgo\Camt\MessageFormatInterface;

/**
 * Class MessageFormat
 * @package Genkgo\Camt\Camt053V3
 */
final class V03 implements MessageFormatInterface
{
    /**
     * @return string
     */
    public function getXmlNs()
    {
        return 'urn:iso:std:iso:20022:tech:xsd:camt.053.001.03';
    }

    /**
     * @return string
     */
    public function getMsgId()
    {
        return 'camt.053.001.03';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'BankToCustomerStatementV03';
    }

    /**
     * @return DecoderInterface
     */
    public function getDecoder()
    {
        $entryTransactionDetailDecoder = new Camt053\Decoder\EntryTransactionDetail();
        $entryDecoder                  = new Decoder\Entry($entryTransactionDetailDecoder);
        $recordDecoder              = new Decoder\Record($entryDecoder);
        $messageDecoder                = new Camt053\Decoder\Message($recordDecoder);

        return new Decoder($messageDecoder, sprintf('/assets/%s.xsd', $this->getMsgId()));
    }
}
