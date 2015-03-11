<?php
namespace Genkgo\Camt;

use DOMDocument;

/**
 * Interface MessageFormatInterface
 * @package Genkgo\Camt
 */
interface MessageFormatInterface
{
    /**
     * @return string
     */
    public function getXmlNs();

    /**
     * @return string
     */
    public function getMsgId();

    /**
     * @return string
     */
    public function getName();

    /**
     * @param DOMDocument $document
     * @return mixed
     */
    public function getMessage(DOMDocument $document);
}
