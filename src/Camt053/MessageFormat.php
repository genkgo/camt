<?php
namespace Genkgo\Camt\Camt053;

use DOMDocument;
use Genkgo\Camt\MessageFormatInterface;

class MessageFormat implements MessageFormatInterface {

    public function getXmlNs()
    {
        return 'urn:iso:std:iso:20022:tech:xsd:camt.053.001.02';
    }

    public function getMsgId()
    {
        return 'camt.053.001.02';
    }

    public function getName()
    {
        return 'BankToCustomerStatementV02';
    }

    public function getMessage(DOMDocument $document)
    {
        return new Message($document);
    }

}