<?php
namespace Genkgo\Camt;

use DOMDocument;

interface MessageFormatInterface {

    public function getXmlNs();

    public function getMsgId();

    public function getName();

    public function getMessage (DOMDocument $document);

}