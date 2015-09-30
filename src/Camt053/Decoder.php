<?php
namespace Genkgo\Camt\Camt053;

use DateTimeImmutable;
use DOMDocument;
use Genkgo\Camt\DecoderInterface;
use Genkgo\Camt\Exception\InvalidMessageException;
use Genkgo\Camt\Iban;
use InvalidArgumentException;
use Money\Currency;
use Money\Money;
use SimpleXMLElement;

class Decoder implements DecoderInterface
{
    /**
     * @var SimpleXMLElement[]
     */
    private $document;

    /**
     * Path to the schema definition
     * @var string
     */
    protected $schemeDefinitionPath;

    /**
     * @param $schemeDefinitionPath
     */
    public function __construct($schemeDefinitionPath) {
        $this->schemeDefinitionPath = $schemeDefinitionPath;
    }

    /**
     * @param DOMDocument $document
     * @throws InvalidMessageException
     */
    private function validate(DOMDocument $document)
    {
        libxml_use_internal_errors(true);
        $valid = $document->schemaValidate(dirname(dirname(__DIR__)).$this->schemeDefinitionPath);
        $errors = libxml_get_errors();
        libxml_clear_errors();

        if (!$valid) {
            $messages = [];
            foreach ($errors as $error) {
                $messages[] = $error->message;
            }

            $errorMessage = implode("\n", $messages);
            throw new InvalidMessageException("Provided XML is not valid according to the XSD:\n{$errorMessage}");
        }
    }

    /**
     * @param DOMDocument $document
     * @return Message
     * @throws InvalidMessageException
     */
    public function decode(DOMDocument $document)
    {
        $this->validate($document);
        $this->document = simplexml_import_dom($document);

        $message = new Message();
        $this->addGroupHeaderToMessage($message);
        $this->addStatementsToMessage($message);

        return $message;
    }

    /**
     * @param SimpleXMLElement $statementXml
     * @param Statement $statement
     */
    private function addBalancesToStatement(SimpleXMLElement $statementXml, Statement $statement)
    {
        $balancesXml = $statementXml->Bal;
        foreach ($balancesXml as $balanceXml) {
            $amount = $this->stringToUnits((string) $balanceXml->Amt);
            $currency = (string)$balanceXml->Amt['Ccy'];
            $date = (string)$balanceXml->Dt->Dt;

            if ((string) $balanceXml->CdtDbtInd === 'DBIT') {
                $amount = $amount * -1;
            }

            if ((string) $balanceXml->Tp->CdOrPrtry->Cd === 'OPBD') {
                $balance = Balance::opening(
                    new Money(
                        $amount,
                        new Currency($currency)
                    ),
                    new DateTimeImmutable($date)
                );
            } else {
                $balance = Balance::closing(
                    new Money(
                        $amount,
                        new Currency($currency)
                    ),
                    new DateTimeImmutable($date)
                );
            }

            $statement->addBalance($balance);
        }
    }

    /**
     * @param SimpleXMLElement $statementXml
     * @param Statement $statement
     */
    private function addEntriesToStatement(SimpleXMLElement $statementXml, Statement $statement)
    {
        $index = 0;
        $entriesXml = $statementXml->Ntry;
        foreach ($entriesXml as $entryXml) {
            $amount = $this->stringToUnits((string) $entryXml->Amt);
            $currency = (string)$entryXml->Amt['Ccy'];
            $bookingDate = (string)$entryXml->BookgDt->Dt;
            $valueDate = (string)$entryXml->ValDt->Dt;

            if ((string) $entryXml->CdtDbtInd === 'DBIT') {
                $amount = $amount * -1;
            }

            $entry = new Entry(
                $statement,
                $index,
                new Money($amount, new Currency($currency)),
                new DateTimeImmutable($bookingDate),
                new DateTimeImmutable($valueDate)
            );

            if (isset($entryXml->RvslInd) && (string) $entryXml->RvslInd === 'true') {
                $entry->setReversalIndicator(true);
            }

            if (isset($entryXml->NtryRef) && (string) $entryXml->NtryRef) {
                $entry->setReference((string) $entryXml->NtryRef);
            }

            if (isset($entryXml->NtryDtls->Btch->PmtInfId) && (string) $entryXml->NtryDtls->Btch->PmtInfId) {
                $entry->setBatchPaymentId((string) $entryXml->NtryDtls->Btch->PmtInfId);
            }

            $this->addTransactionDetailsToEntry($entryXml, $entry);

            $statement->addEntry($entry);
            $index++;
        }
    }

    /**
     * @param SimpleXMLElement $entryXml
     * @param Entry $entry
     */
    private function addTransactionDetailsToEntry(SimpleXMLElement $entryXml, Entry $entry)
    {
        $detailsXml = $entryXml->NtryDtls->TxDtls;
        if ($detailsXml) {
            foreach ($detailsXml as $detailXml) {
                $detail = new EntryTransactionDetail();
                $this->addReferencesToTransactionDetails($detailXml, $detail);
                $this->addRelatedPartiesToTransactionDetails($detailXml, $detail);
                $this->addRemittanceInformationToTransactionDetails($detailXml, $detail);
                $this->addReturnInformationToTransactionDetails($detailXml, $detail);
                $entry->addTransactionDetail($detail);
            }
        }
    }

    /**
     * @param SimpleXMLElement $detailXml
     * @param EntryTransactionDetail $detail
     */
    private function addRelatedPartiesToTransactionDetails(SimpleXMLElement $detailXml, EntryTransactionDetail $detail)
    {
        if (isset($detailXml->RltdPties)) {
            foreach ($detailXml->RltdPties as $relatedPartyXml) {

                if (isset($relatedPartyXml->Cdtr)) {
                    $relatedPartyTypeXml = $relatedPartyXml->Cdtr;
                    $relatedPartyTypeAccountXml = $relatedPartyXml->CdtrAcct;
                    $relatedPartyType = $creditor = new Creditor((string) $relatedPartyTypeXml->Nm);
                } elseif (isset($relatedPartyXml->Dbtr)) {
                    $relatedPartyTypeXml = $relatedPartyXml->Dbtr;
                    $relatedPartyTypeAccountXml = $relatedPartyXml->DbtrAcct;
                    $relatedPartyType = $creditor = new Debtor((string) $relatedPartyTypeXml->Nm);
                } else {
                    continue;
                }

                if (isset($relatedPartyTypeXml->PstlAdr)) {
                    $address = new Address();
                    if (isset($relatedPartyTypeXml->PstlAdr->Ctry)) {
                        $address = $address->setCountry($relatedPartyTypeXml->PstlAdr->Ctry);
                    }
                    if (isset($relatedPartyTypeXml->PstlAdr->AdrLine)) {
                        foreach ($relatedPartyTypeXml->PstlAdr->AdrLine as $line) {
                            $address = $address->addAddressLine((string)$line);
                        }
                    }

                    $relatedPartyType->setAddress($address);
                }

                if (isset($relatedPartyTypeAccountXml->Id->IBAN) && $ibanCode = (string) $relatedPartyTypeAccountXml->Id->IBAN) {
                    $account = new Account(new Iban($ibanCode));
                } else {
                    $account = null;
                }

                $relatedParty = new RelatedParty($relatedPartyType, $account);
                $detail->addRelatedParty($relatedParty);
            }
        }
    }

    /**
     * @param SimpleXMLElement $detailXml
     * @param EntryTransactionDetail $detail
     */
    private function addReferencesToTransactionDetails(SimpleXMLElement $detailXml, EntryTransactionDetail $detail)
    {
        if (isset($detailXml->Refs->EndToEndId)) {
            $endToEndId = (string)$detailXml->Refs->EndToEndId;
            if (isset($detailXml->Refs->MndtId)) {
                $mandateId = (string)$detailXml->Refs->MndtId;
            } else {
                $mandateId = null;
            }
            $detail->addReference(new Reference($endToEndId, $mandateId));
        }
    }

    /**
     * @param SimpleXMLElement $detailXml
     * @param EntryTransactionDetail $detail
     */
    private function addRemittanceInformationToTransactionDetails(SimpleXMLElement $detailXml, EntryTransactionDetail $detail)
    {
        if (isset($detailXml->RmtInf)) {
            if (isset($detailXml->RmtInf->Ustrd)) {
                $remittanceInformation = RemittanceInformation::fromUnstructured(
                    (string)$detailXml->RmtInf->Ustrd
                );
                $detail->setRemittanceInformation($remittanceInformation);
            }
        }
    }

    /**
     * @param SimpleXMLElement $detailXml
     * @param EntryTransactionDetail $detail
     */
    private function addReturnInformationToTransactionDetails(SimpleXMLElement $detailXml, EntryTransactionDetail $detail)
    {
        if (isset($detailXml->RtrInf)) {
            if (isset($detailXml->RtrInf->Rsn->Cd)) {
                $remittanceInformation = ReturnInformation::fromUnstructured(
                    (string)$detailXml->RtrInf->Rsn->Cd,
                    (string)$detailXml->RtrInf->AddtlInf
                );
                $detail->setReturnInformation($remittanceInformation);
            }
        }
    }

    /**
     * @param Message $message
     */
    private function addGroupHeaderToMessage(Message $message)
    {
        $groupHeaderXml = $this->document->BkToCstmrStmt->GrpHdr;
        $groupHeader = new GroupHeader(
            (string)$groupHeaderXml->MsgId,
            new DateTimeImmutable((string)$groupHeaderXml->CreDtTm)
        );

        $message->setGroupHeader($groupHeader);
    }

    /**
     * @param Message $message
     */
    private function addStatementsToMessage($message)
    {
        $statements = [];

        $statementsXml = $this->document->BkToCstmrStmt->Stmt;
        foreach ($statementsXml as $statementXml) {
            $statement = new Statement(
                $statementXml->Id,
                new DateTimeImmutable((string)$statementXml->CreDtTm),
                new Account(new Iban((string)$statementXml->Acct->Id->IBAN))
            );

            $this->addBalancesToStatement($statementXml, $statement);
            $this->addEntriesToStatement($statementXml, $statement);

            $statements[] = $statement;
        }

        $message->setStatements($statements);
    }

    /**
     * Converts a string value with an amount into an integer.
     * Supports up to 5 decimals points.
     *
     * Credit goes to the mathiasverraes/money library
     *
     * @param $string
     * @throws \Money\InvalidArgumentException
     * @return int
     */
    private function stringToUnits($string)
    {
        $sign = "(?P<sign>[-\+])?";
        $digits = "(?P<digits>\d*)";
        $separator = "(?P<separator>[.,])?";
        $decimals = "(?P<decimal1>\d)?(?P<decimal2>\d)";
        $pattern = "/^".$sign.$digits.$separator.$decimals."$/";

        if (!preg_match($pattern, trim($string), $matches)) {
            throw new InvalidArgumentException("The value could not be parsed as money");
        }

        $units = $matches['sign'] == "-" ? "-" : "";
        $units .= $matches['digits'];
        $units .= isset($matches['decimal1']) ? $matches['decimal1'] : "0";
        $units .= isset($matches['decimal2']) ? $matches['decimal2'] : "0";

        return (int) $units;
    }

}
