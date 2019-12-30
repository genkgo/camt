<?php
namespace Genkgo\Camt;

/**
 * Interface MessageFormatInterface
 * @package Genkgo\Camt
 */
interface MessageFormatInterface
{
    /**
     * @return string
     */
    public function getXmlNs(): string;

    /**
     * @return string
     */
    public function getMsgId(): string;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return DecoderInterface
     */
    public function getDecoder(): DecoderInterface;
}
