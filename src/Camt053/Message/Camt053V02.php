<?php
namespace Genkgo\Camt\Camt053\Message;

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
        return new Decoder('/assets/camt.053.001.02.xsd');
    }
}
