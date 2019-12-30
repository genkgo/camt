<?php

declare(strict_types=1);

namespace Genkgo\TestCamt\Unit\Decoder;

use Genkgo\Camt\Decoder\Date;
use Genkgo\TestCamt\AbstractTestCase;
use Genkgo\Camt\Camt053;
use Genkgo\Camt\DTO;
use Money\Money;
use Prophecy\Argument;
use SimpleXMLElement;

class EntryTransactionDetailTest extends AbstractTestCase
{
    /**
     * @test
     */
    public function it_does_not_add_reference_if_there_is_none_in_xml(): void
    {
        $detail = $this->prophesize(DTO\EntryTransactionDetail::class);
        $detail->setReference(Argument::any())->shouldNotBeCalled();

        $xmlDetail = new SimpleXMLElement('<content></content>');
        (new Camt053\Decoder\EntryTransactionDetail(new Date()))->addReference($detail->reveal(), $xmlDetail);
    }

    /**
     * @test
     */
    public function it_adds_reference_if_it_is_present_in_xml(): void
    {
        $detail = $this->prophesize(DTO\EntryTransactionDetail::class);
        $detail->setReference(Argument::type(DTO\Reference::class))->shouldBeCalled();

        (new Camt053\Decoder\EntryTransactionDetail(new Date()))->addReference($detail->reveal(), $this->getXmlDetail());
    }

    /**
     * @test
     */
    public function it_does_not_add_additional_transaction_information_if_there_is_none_in_xml(): void
    {
        $detail = $this->prophesize(DTO\EntryTransactionDetail::class);
        $detail->setAdditionalTransactionInformation(Argument::any())->shouldNotBeCalled();

        $xmlDetail = new SimpleXMLElement('<content></content>');
        (new Camt053\Decoder\EntryTransactionDetail(new Date()))->addAdditionalTransactionInformation($detail->reveal(), $xmlDetail);
    }

    /**
     * @test
     */
    public function it_adds_additional_transaction_information_if_it_is_present_in_xml(): void
    {
        $detail = $this->prophesize(DTO\EntryTransactionDetail::class);
        $detail->setAdditionalTransactionInformation(
            Argument::type(DTO\AdditionalTransactionInformation::class)
        )->shouldBeCalled();

        (new Camt053\Decoder\EntryTransactionDetail(new Date()))->addAdditionalTransactionInformation($detail->reveal(), $this->getXmlDetail());
    }

    /**
     * @test
     */
    public function it_does_not_add_remittance_information_if_there_is_none_in_xml(): void
    {
        $detail = $this->prophesize(DTO\EntryTransactionDetail::class);
        $detail->setRemittanceInformation(Argument::any())->shouldNotBeCalled();

        $xmlDetail = new SimpleXMLElement('<content></content>');
        (new Camt053\Decoder\EntryTransactionDetail(new Date()))->addRemittanceInformation($detail->reveal(), $xmlDetail);
    }

    /**
     * @test
     */
    public function it_adds_remittance_information_and_creditor_reference_if_it_is_present_in_xml(): void
    {
        $detail = $this->prophesize(DTO\EntryTransactionDetail::class);
        $detail->setRemittanceInformation(Argument::type(DTO\RemittanceInformation::class))->shouldBeCalled();

        (new Camt053\Decoder\EntryTransactionDetail(new Date()))->addRemittanceInformation($detail->reveal(), $this->getXmlDetail());
    }

    /**
     * @test
     */
    public function it_adds_remittance_information_if_it_is_present_in_xml(): void
    {
        $detail = $this->prophesize(DTO\EntryTransactionDetail::class);
        $detail->setRemittanceInformation(Argument::type(DTO\RemittanceInformation::class))->shouldBeCalled();

        $xmlDetail = new SimpleXMLElement('<content><RmtInf><Ustrd>Lorem</Ustrd></RmtInf></content>');
        (new Camt053\Decoder\EntryTransactionDetail(new Date()))->addRemittanceInformation($detail->reveal(), $xmlDetail);
    }

    /**
     * @test
     */
    public function it_does_not_add_return_information_if_there_is_none_in_xml(): void
    {
        $detail = $this->prophesize(DTO\EntryTransactionDetail::class);
        $detail->setReturnInformation(Argument::any())->shouldNotBeCalled();

        $xmlDetail = new SimpleXMLElement('<content></content>');
        (new Camt053\Decoder\EntryTransactionDetail(new Date()))->addReturnInformation($detail->reveal(), $xmlDetail);
    }

    /**
     * @test
     */
    public function it_adds_return_information_if_it_is_present_in_xml(): void
    {
        $detail = $this->prophesize(DTO\EntryTransactionDetail::class);
        $detail->setReturnInformation(
            Argument::type(DTO\ReturnInformation::class)
        )->shouldBeCalled();

        (new Camt053\Decoder\EntryTransactionDetail(new Date()))->addReturnInformation($detail->reveal(), $this->getXmlDetail());
    }

    /**
     * @test
     */
    public function it_does_not_add_related_parties_if_there_is_none_in_xml(): void
    {
        $detail = $this->prophesize(DTO\EntryTransactionDetail::class);
        $detail->addRelatedParty(Argument::any())->shouldNotBeCalled();

        $xmlDetail = new SimpleXMLElement('<content></content>');
        (new Camt053\Decoder\EntryTransactionDetail(new Date()))->addRelatedParties($detail->reveal(), $xmlDetail);
    }

    /**
     * @test
     */
    public function it_adds_related_parties_if_is_present_in_xml(): void
    {
        $detail = $this->prophesize(DTO\EntryTransactionDetail::class);
        $detail->addRelatedParty(Argument::type(DTO\RelatedParty::class))->shouldBeCalled();

        (new Camt053\Decoder\EntryTransactionDetail(new Date()))->addRelatedParties($detail->reveal(), $this->getXmlDetail());
    }

    /**
     * @test
     */
    public function it_does_not_add_related_dates_if_there_is_none_in_xml(): void
    {
        $detail = $this->prophesize(DTO\EntryTransactionDetail::class);
        $detail->setRelatedDates(Argument::any())->shouldNotBeCalled();

        $xmlDetail = new SimpleXMLElement('<content></content>');
        (new Camt053\Decoder\EntryTransactionDetail(new Date()))->addRelatedDates($detail->reveal(), $xmlDetail);
    }

    /**
     * @test
     */
    public function it_adds_related_dates_if_is_present_in_xml(): void
    {
        $detail = $this->prophesize(DTO\EntryTransactionDetail::class);
        $detail->setRelatedDates(Argument::type(DTO\RelatedDates::class))->shouldBeCalled();

        (new Camt053\Decoder\EntryTransactionDetail(new Date()))->addRelatedDates($detail->reveal(), $this->getXmlDetail());
    }

    /**
     * @test
     */
    public function it_does_not_add_charges_if_there_is_none_in_xml(): void
    {
        $detail = $this->prophesize(DTO\EntryTransactionDetail::class);
        $detail->setCharges(Argument::any())->shouldNotBeCalled();

        $xmlDetail = new SimpleXMLElement('<content></content>');
        (new Camt053\Decoder\EntryTransactionDetail(new Date()))->addCharges($detail->reveal(), $xmlDetail);
    }

    /**
     * @test
     */
    public function it_adds_charges_if_is_present_in_xml(): void
    {
        $detail = $this->prophesize(DTO\EntryTransactionDetail::class);
        $detail->setCharges(Argument::type(DTO\Charges::class))->shouldBeCalled();

        (new Camt053\Decoder\EntryTransactionDetail(new Date()))->addCharges($detail->reveal(), $this->getXmlDetail());
    }

    /**
     * @test
     */
    public function it_adds_amount_details_if_is_present_in_xmsl(): void
    {
        $detail = $this->prophesize(DTO\EntryTransactionDetail::class);
        $detail->setAmountDetails(Argument::type(Money::class))->shouldBeCalled();

        $CdtDbtInd = new SimpleXMLElement('<content>DBIT</content>');
        (new Camt053\Decoder\EntryTransactionDetail(new Date()))->addAmountDetails($detail->reveal(), $this->getXmlDetail(), $CdtDbtInd);
    }
    /**
     * @test
     */
    public function it_adds_amount_if_is_present_in_xmsl(): void
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
