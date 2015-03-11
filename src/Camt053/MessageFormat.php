<?php
namespace Genkgo\Camt\Camt053;

use DOMDocument;
use Genkgo\Camt\MessageFormatInterface;

/**
 * Class MessageFormat
 * @package Genkgo\Camt\Camt053
 */
class MessageFormat implements MessageFormatInterface
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
     * @param DOMDocument $document
     * @return Message
     */
    public function getMessage(DOMDocument $document)
    {
        return new Message($document);
    }
}
