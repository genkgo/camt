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
     * @return DecoderInterface
     */
    public function getDecoder();
}
