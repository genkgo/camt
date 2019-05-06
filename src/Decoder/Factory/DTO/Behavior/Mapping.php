<?php

namespace Genkgo\Camt\Decoder\Factory\DTO\Behavior;

use SimpleXMLElement;

trait Mapping
{
    /**
     * @param object $object
     * @param SimpleXMLElement $xml
     * @param array $mapping
     */
    public static function map($object, SimpleXMLElement $xml, array $mapping)
    {
        foreach ($mapping as $line) {
            $setter   = $line['setter'];
            $xmlValue = $line['value'];

            if (isset($xml->$xmlValue)) {
                $object->$setter((string) $xml->$xmlValue);
            }
        }
    }
}
