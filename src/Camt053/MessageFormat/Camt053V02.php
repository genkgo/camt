<?php

namespace Genkgo\Camt\Camt053\MessageFormat;

use Genkgo\Camt\Camt053\Decoder;
use Genkgo\Camt\DecoderInterface;
use Genkgo\Camt\MessageFormatInterface;

/**
 * Class MessageFormat
 * @package Genkgo\Camt\Camt053
 */
final class Camt053V02 implements MessageFormatInterface
{
    /**
     * @return string
     */
    public function getXmlNs()
    {
        return 'urn:iso:std:iso:20022:tech:xsd:camt.053.001.02';
    }

    /**
     * @return string
     */
    public function getMsgId()
    {
        return 'camt.053.001.02';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'BankToCustomerStatementV02';
    }

    /**
     * @return DecoderInterface
     */
    public function getDecoder()
    {
        $entryTransactionDetailDecoder = new Decoder\EntryTransactionDetail();
        $entryDecoder                  = new Decoder\Entry($entryTransactionDetailDecoder);
        $statementDecoder              = new Decoder\Statement($entryDecoder);
        $messageDecoder                = new Decoder\Message($statementDecoder);

        return new Decoder($messageDecoder, '/assets/camt.053.001.02.xsd');
    }
}
