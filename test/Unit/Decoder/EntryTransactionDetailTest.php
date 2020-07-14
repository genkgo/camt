<?php

declare(strict_types=1);

namespace Genkgo\TestCamt\Unit\Decoder;

use Genkgo\Camt\Camt053;
use Genkgo\Camt\Decoder\Date;
use Genkgo\Camt\DTO;
use Genkgo\TestCamt\AbstractTestCase;
use Money\Money;
use Prophecy\Argument;
use SimpleXMLElement;

class EntryTransactionDetailTest extends AbstractTestCase
{
    public function testItDoesNotAddReferenceIfThereIsNoneInXml(): void
    {
        $detail = $this->prophesize(DTO\EntryTransactionDetail::class);
        $detail->setReference(Argument::any())->shouldNotBeCalled();

        $xmlDetail = new SimpleXMLElement('<content></content>');
        (new Camt053\Decoder\EntryTransactionDetail(new Date()))->addReference($detail->reveal(), $xmlDetail);
    }

    public function testItAddsReferenceIfItIsPresentInXml(): void
    {
        $detail = $this->prophesize(DTO\EntryTransactionDetail::class);
        $detail->setReference(Argument::type(DTO\Reference::class))->shouldBeCalled();

        (new Camt053\Decoder\EntryTransactionDetail(new Date()))->addReference($detail->reveal(), $this->getXmlDetail());
    }

    public function testItDoesNotAddAdditionalTransactionInformationIfThereIsNoneInXml(): void
    {
        $detail = $this->prophesize(DTO\EntryTransactionDetail::class);
        $detail->setAdditionalTransactionInformation(Argument::any())->shouldNotBeCalled();

        $xmlDetail = new SimpleXMLElement('<content></content>');
        (new Camt053\Decoder\EntryTransactionDetail(new Date()))->addAdditionalTransactionInformation($detail->reveal(), $xmlDetail);
    }

    public function testItAddsAdditionalTransactionInformationIfItIsPresentInXml(): void
    {
        $detail = $this->prophesize(DTO\EntryTransactionDetail::class);
        $detail->setAdditionalTransactionInformation(
            Argument::type(DTO\AdditionalTransactionInformation::class)
        )->shouldBeCalled();

        (new Camt053\Decoder\EntryTransactionDetail(new Date()))->addAdditionalTransactionInformation($detail->reveal(), $this->getXmlDetail());
    }

    public function testItDoesNotAddRemittanceInformationIfThereIsNoneInXml(): void
    {
        $detail = $this->prophesize(DTO\EntryTransactionDetail::class);
        $detail->setRemittanceInformation(Argument::any())->shouldNotBeCalled();

        $xmlDetail = new SimpleXMLElement('<content></content>');
        (new Camt053\Decoder\EntryTransactionDetail(new Date()))->addRemittanceInformation($detail->reveal(), $xmlDetail);
    }

    public function testItAddsRemittanceInformationAndCreditorReferenceIfItIsPresentInXml(): void
    {
        $detail = $this->prophesize(DTO\EntryTransactionDetail::class);
        $detail->setRemittanceInformation(Argument::type(DTO\RemittanceInformation::class))->shouldBeCalled();

        (new Camt053\Decoder\EntryTransactionDetail(new Date()))->addRemittanceInformation($detail->reveal(), $this->getXmlDetail());
    }

    public function testItAddsRemittanceInformationIfItIsPresentInXml(): void
    {
        $detail = $this->prophesize(DTO\EntryTransactionDetail::class);
        $detail->setRemittanceInformation(Argument::type(DTO\RemittanceInformation::class))->shouldBeCalled();

        $xmlDetail = new SimpleXMLElement('<content><RmtInf><Ustrd>Lorem</Ustrd></RmtInf></content>');
        (new Camt053\Decoder\EntryTransactionDetail(new Date()))->addRemittanceInformation($detail->reveal(), $xmlDetail);
    }

    public function testItDoesNotAddReturnInformationIfThereIsNoneInXml(): void
    {
        $detail = $this->prophesize(DTO\EntryTransactionDetail::class);
        $detail->setReturnInformation(Argument::any())->shouldNotBeCalled();

        $xmlDetail = new SimpleXMLElement('<content></content>');
        (new Camt053\Decoder\EntryTransactionDetail(new Date()))->addReturnInformation($detail->reveal(), $xmlDetail);
    }

    public function testItAddsReturnInformationIfItIsPresentInXml(): void
    {
        $detail = $this->prophesize(DTO\EntryTransactionDetail::class);
        $detail->setReturnInformation(
            Argument::type(DTO\ReturnInformation::class)
        )->shouldBeCalled();

        (new Camt053\Decoder\EntryTransactionDetail(new Date()))->addReturnInformation($detail->reveal(), $this->getXmlDetail());
    }

    public function testItDoesNotAddRelatedPartiesIfThereIsNoneInXml(): void
    {
        $detail = $this->prophesize(DTO\EntryTransactionDetail::class);
        $detail->addRelatedParty(Argument::any())->shouldNotBeCalled();

        $xmlDetail = new SimpleXMLElement('<content></content>');
        (new Camt053\Decoder\EntryTransactionDetail(new Date()))->addRelatedParties($detail->reveal(), $xmlDetail);
    }

    public function testItAddsRelatedPartiesIfIsPresentInXml(): void
    {
        $detail = $this->prophesize(DTO\EntryTransactionDetail::class);
        $detail->addRelatedParty(Argument::type(DTO\RelatedParty::class))->shouldBeCalled();

        (new Camt053\Decoder\EntryTransactionDetail(new Date()))->addRelatedParties($detail->reveal(), $this->getXmlDetail());
    }

    public function testItDoesNotAddRelatedDatesIfThereIsNoneInXml(): void
    {
        $detail = $this->prophesize(DTO\EntryTransactionDetail::class);
        $detail->setRelatedDates(Argument::any())->shouldNotBeCalled();

        $xmlDetail = new SimpleXMLElement('<content></content>');
        (new Camt053\Decoder\EntryTransactionDetail(new Date()))->addRelatedDates($detail->reveal(), $xmlDetail);
    }

    public function testItAddsRelatedDatesIfIsPresentInXml(): void
    {
        $detail = $this->prophesize(DTO\EntryTransactionDetail::class);
        $detail->setRelatedDates(Argument::type(DTO\RelatedDates::class))->shouldBeCalled();

        (new Camt053\Decoder\EntryTransactionDetail(new Date()))->addRelatedDates($detail->reveal(), $this->getXmlDetail());
    }

    public function testItDoesNotAddChargesIfThereIsNoneInXml(): void
    {
        $detail = $this->prophesize(DTO\EntryTransactionDetail::class);
        $detail->setCharges(Argument::any())->shouldNotBeCalled();

        $xmlDetail = new SimpleXMLElement('<content></content>');
        (new Camt053\Decoder\EntryTransactionDetail(new Date()))->addCharges($detail->reveal(), $xmlDetail);
    }

    public function testItAddsChargesIfIsPresentInXml(): void
    {
        $detail = $this->prophesize(DTO\EntryTransactionDetail::class);
        $detail->setCharges(Argument::type(DTO\Charges::class))->shouldBeCalled();

        (new Camt053\Decoder\EntryTransactionDetail(new Date()))->addCharges($detail->reveal(), $this->getXmlDetail());
    }

    public function testItAddsAmountDetailsIfIsPresentInXmsl(): void
    {
        $detail = $this->prophesize(DTO\EntryTransactionDetail::class);
        $detail->setAmountDetails(Argument::type(Money::class))->shouldBeCalled();

        $CdtDbtInd = new SimpleXMLElement('<content>DBIT</content>');
        (new Camt053\Decoder\EntryTransactionDetail(new Date()))->addAmountDetails($detail->reveal(), $this->getXmlDetail(), $CdtDbtInd);
    }

    public function testItAddsAmountIfIsPresentInXmsl(): void
    {
        $detail = $this->prophesize(DTO\EntryTransactionDetail::class);
        $detail->setAmount(Argument::type(Money::class))->shouldBeCalled();

        $CdtDbtInd = new SimpleXMLElement('<content>DBIT</content>');
        (new Camt053\Decoder\EntryTransactionDetail(new Date()))->addAmount($detail->reveal(), $this->getXmlDetail(), $CdtDbtInd);
    }

    private function getXmlDetail(): SimpleXMLElement
    {
        $xmlContent = <<<XML
<content>
    <Refs>
        <EndToEndId>some end to end id</EndToEndId>
        <MndtId>some mandate id</MndtId>
    </Refs>
    <AddtlTxInf>additional transaction information</AddtlTxInf>
    <RtrInf>
        <Rsn>
            <Cd>lorem</Cd>
        </Rsn>
        <AddtlInf>ipsum</AddtlInf>
    </RtrInf>
    <RmtInf>
        <Strd>
            <CdtrRefInf>
                <Ref>Some reference</Ref>
            </CdtrRefInf>
            <Cd>lorem</Cd>
        </Strd>
    </RmtInf>
    <RltdDts>
      <AccptncDtTm>2017-02-27T15:23:45.446</AccptncDtTm>
    </RltdDts>
    <Chrgs>
      <TtlChrgsAndTaxAmt Ccy="CHF">1.79</TtlChrgsAndTaxAmt>
      <Rcrd>
        <Amt Ccy="CHF">1.75</Amt>
        <CdtDbtInd>DBIT</CdtDbtInd>
        <ChrgInclInd>false</ChrgInclInd>
        <Tp>
          <Prtry>
            <Id>2</Id>
          </Prtry>
        </Tp>
      </Rcrd>
      <Rcrd>
        <Amt Ccy="CHF">0.04</Amt>
        <CdtDbtInd>DBIT</CdtDbtInd>
        <ChrgInclInd>false</ChrgInclInd>
        <Tp>
          <Prtry>
            <Id>4</Id>
          </Prtry>
        </Tp>
      </Rcrd>
    </Chrgs>    
    <RltdPties>
        <Cdtr>
            <Nm>Lorem</Nm>
            <PstlAdr>
                <Ctry>NL</Ctry>
                <AdrLine>NL</AdrLine>
            </PstlAdr>
        </Cdtr>
        <CdtrAcct>
            <Id>
                <IBAN>NL39ULSS6234823955</IBAN>
            </Id>
        </CdtrAcct>
    </RltdPties>
    <AmtDtls>
      <TxAmt>
        <Amt Ccy="CHF">3.1</Amt>
      </TxAmt>
    </AmtDtls>
    <Amt Ccy="CHF">3.1</Amt>
</content>
XML;

        return new SimpleXMLElement($xmlContent);
    }
}
