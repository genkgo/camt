<?php

namespace Genkgo\Camt\Unit\Camt053\Decoder;

use Genkgo\Camt\AbstractTestCase;
use Genkgo\Camt\Camt053\Decoder;
use Genkgo\Camt\Camt053\DTO;
use Prophecy\Argument;

class EntryTransactionDetailTest extends AbstractTestCase
{
    /**
     * @test
     */
    public function it_does_not_add_reference_if_there_is_none_in_xml()
    {
        $detail = $this->prophesize(DTO\EntryTransactionDetail::class);
        $detail->addReference(Argument::any())->shouldNotBeCalled();

        $xmlDetail = new \SimpleXMLElement('<content></content>');
        (new Decoder\EntryTransactionDetail())->addReferences($detail->reveal(), $xmlDetail);
    }

    /**
     * @test
     */
    public function it_adds_reference_if_it_is_present_in_xml()
    {
        $detail = $this->prophesize(DTO\EntryTransactionDetail::class);
        $detail->addReference(Argument::type(DTO\Reference::class))->shouldBeCalled();

        (new Decoder\EntryTransactionDetail())->addReferences($detail->reveal(), $this->getXmlDetail());
    }

    /**
     * @test
     */
    public function it_does_not_add_additional_transaction_information_if_there_is_none_in_xml()
    {
        $detail = $this->prophesize(DTO\EntryTransactionDetail::class);
        $detail->setAdditionalTransactionInformation(Argument::any())->shouldNotBeCalled();

        $xmlDetail = new \SimpleXMLElement('<content></content>');
        (new Decoder\EntryTransactionDetail())->addAdditionalTransactionInformation($detail->reveal(), $xmlDetail);
    }

    /**
     * @test
     */
    public function it_adds_additional_transaction_information_if_it_is_present_in_xml()
    {
        $detail = $this->prophesize(DTO\EntryTransactionDetail::class);
        $detail->setAdditionalTransactionInformation(
            Argument::type(DTO\AdditionalTransactionInformation::class)
        )->shouldBeCalled();

        (new Decoder\EntryTransactionDetail())->addAdditionalTransactionInformation($detail->reveal(), $this->getXmlDetail());
    }

    /**
     * @test
     */
    public function it_does_not_add_remittance_information_if_there_is_none_in_xml()
    {
        $detail = $this->prophesize(DTO\EntryTransactionDetail::class);
        $detail->setRemittanceInformation(Argument::any())->shouldNotBeCalled();

        $xmlDetail = new \SimpleXMLElement('<content></content>');
        (new Decoder\EntryTransactionDetail())->addRemittanceInformation($detail->reveal(), $xmlDetail);
    }

    /**
     * @test
     */
    public function it_adds_remittance_information_and_creditor_reference_if_it_is_present_in_xml()
    {
        $detail = $this->prophesize(DTO\EntryTransactionDetail::class);
        $detail->setRemittanceInformation(Argument::type(DTO\RemittanceInformation::class))->shouldBeCalled();

        (new Decoder\EntryTransactionDetail())->addRemittanceInformation($detail->reveal(), $this->getXmlDetail());
    }

    /**
     * @test
     */
    public function it_adds_remittance_information_if_it_is_present_in_xml()
    {
        $detail = $this->prophesize(DTO\EntryTransactionDetail::class);
        $detail->setRemittanceInformation(Argument::type(DTO\RemittanceInformation::class))->shouldBeCalled();

        $xmlDetail = new \SimpleXMLElement('<content><RmtInf><Ustrd>Lorem</Ustrd></RmtInf></content>');
        (new Decoder\EntryTransactionDetail())->addRemittanceInformation($detail->reveal(), $xmlDetail);
    }

    /**
     * @test
     */
    public function it_does_not_add_return_information_if_there_is_none_in_xml()
    {
        $detail = $this->prophesize(DTO\EntryTransactionDetail::class);
        $detail->setReturnInformation(Argument::any())->shouldNotBeCalled();

        $xmlDetail = new \SimpleXMLElement('<content></content>');
        (new Decoder\EntryTransactionDetail())->addReturnInformation($detail->reveal(), $xmlDetail);
    }

    /**
     * @test
     */
    public function it_adds_return_information_if_it_is_present_in_xml()
    {
        $detail = $this->prophesize(DTO\EntryTransactionDetail::class);
        $detail->setReturnInformation(
            Argument::type(DTO\ReturnInformation::class)
        )->shouldBeCalled();

        (new Decoder\EntryTransactionDetail())->addReturnInformation($detail->reveal(), $this->getXmlDetail());
    }

    /**
     * @test
     */
    public function it_does_not_add_related_parties_if_there_is_none_in_xml()
    {
        $detail = $this->prophesize(DTO\EntryTransactionDetail::class);
        $detail->addRelatedParty(Argument::any())->shouldNotBeCalled();

        $xmlDetail = new \SimpleXMLElement('<content></content>');
        (new Decoder\EntryTransactionDetail())->addRelatedParties($detail->reveal(), $xmlDetail);
    }

    /**
     * @test
     */
    public function it_adds_related_parties_if_is_present_in_xml()
    {
        $detail = $this->prophesize(DTO\EntryTransactionDetail::class);
        $detail->addRelatedParty(Argument::type(DTO\RelatedParty::class))->shouldBeCalled();

        (new Decoder\EntryTransactionDetail())->addRelatedParties($detail->reveal(), $this->getXmlDetail());
    }

    private function getXmlDetail()
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
</content>
XML;

        return new \SimpleXMLElement($xmlContent);
    }
}
