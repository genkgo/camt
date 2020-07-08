<?php

declare(strict_types=1);

namespace Genkgo\Camt\Decoder\Factory\DTO\Behavior;

use SimpleXMLElement;

trait Mapping
{
    /**
     * @param string[][] $mapping
     */
    public static function map(object $object, SimpleXMLElement $xml, array $mapping): void
    {
        foreach ($mapping as $line) {
            $setter = $line['setter'];
            $xmlValue = $line['value'];

            if (isset($xml->$xmlValue)) {
                $object->$setter((string) $xml->$xmlValue);
            }
        }
    }
}
