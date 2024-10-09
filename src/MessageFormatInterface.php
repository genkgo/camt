<?php

declare(strict_types=1);

namespace Genkgo\Camt;

/**
 * Interface MessageFormatInterface.
 */
interface MessageFormatInterface
{
    public function getXmlNs(): string;

    public function getMsgId(): string;

    public function getName(): string;

    public function getDecoder(): DecoderInterface;
}
