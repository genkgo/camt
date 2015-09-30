<?php
namespace Genkgo\Camt\Camt053V03;

use DateTimeImmutable;
use DOMDocument;
use Genkgo\Camt\DecoderInterface;
use Genkgo\Camt\Exception\InvalidMessageException;
use Genkgo\Camt\Iban;
use Money\Currency;
use Money\Money;
use SimpleXMLElement;

class Decoder extends \Genkgo\Camt\Camt053\Decoder implements DecoderInterface
{
    /**
     * @var SimpleXMLElement[]
     */
    private $document;

    /**
     * Path to the schema definition
     * @var string
     */
    protected $schemeDefinitionPath = '/assets/camt.053.001.03.xsd';
}
