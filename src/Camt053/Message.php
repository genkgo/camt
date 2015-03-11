<?php
namespace Genkgo\Camt\Camt053;

use DateTimeImmutable;
use DOMDocument;
use Genkgo\Camt\Exception\InvalidMessageException;
use Genkgo\Camt\Iban;
use Money\Currency;
use Money\Money;

/**
 * Class Message
 * @package Genkgo\Camt\Camt053
 */
class Message {

    /**
     * @var \SimpleXMLElement[]
     */
    private $document;
    /**
     * @var
     */
    private $groupHeader;
    /**
     * @var
     */
    private $statements;

    /**
     * @param DOMDocument $document
     * @throws InvalidMessageException
     */
    public function __construct(DOMDocument $document) {
        $this->validate($document);
        $this->document = simplexml_import_dom($document);
    }

    /**
     * @return GroupHeader
     */
    public function getGroupHeader() {
        if ($this->groupHeader === null) {
            $groupHeaderXml = $this->document->BkToCstmrStmt->GrpHdr;

            $this->groupHeader = new GroupHeader(
                (string) $groupHeaderXml->MsgId,
                new DateTimeImmutable((string) $groupHeaderXml->CreDtTm)
            );
        }

        return $this->groupHeader;
    }

    /**
     * @return Statement[]
     */
    public function getStatements() {
        if ($this->statements === null) {
            $this->statements = [];

            $statementsXml = $this->document->BkToCstmrStmt->Stmt;
            foreach ($statementsXml as $statementXml) {
                $statement = new Statement(
                    $statementXml->Id,
                    new DateTimeImmutable((string) $statementXml->CreDtTm),
                    new Account(new Iban((string) $statementXml->Acct->Id->IBAN))
                );

                $this->addBalancesToStatement($statementXml, $statement);

                $this->statements[] = $statement;
            }

        }

        return $this->statements;
    }

    /**
     * @param DOMDocument $document
     * @throws InvalidMessageException
     */
    private function validate (DOMDocument $document) {
        libxml_use_internal_errors(true);
        $valid = $document->schemaValidate(dirname(dirname(__DIR__)).'/assets/camt.053.001.02.xsd', LIBXML_SCHEMA_CREATE);
        $errors = libxml_get_errors();
        libxml_clear_errors();

        if (!$valid) {
            throw new InvalidMessageException("Provided XML is not valid according to the XSD");
        }
    }

    /**
     * @param $statementXml
     * @param $statement
     */
    private function addBalancesToStatement($statementXml, $statement)
    {
        $balancesXml = $statementXml->Bal;
        foreach ($balancesXml as $balanceXml) {
            $amount = (string)$balanceXml->Amt;
            $currency = (string)$balanceXml->Amt['Ccy'];
            $date = (string)$balanceXml->Dt->Dt;

            if ($balanceXml->Tp->CdOrPrtry->Cd === 'OPBD') {
                $balance = Balance::opening(
                    new Money(
                        Money::stringToUnits($amount),
                        new Currency($currency)
                    ),
                    new DateTimeImmutable($date)
                );
            } else {
                $balance = Balance::closing(
                    new Money(
                        Money::stringToUnits($amount),
                        new Currency($currency)
                    ),
                    new DateTimeImmutable($date)
                );
            }

            $statement->addBalance($balance);
        }
    }

}