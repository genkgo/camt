<?php

namespace Genkgo\Camt\DTO;

/**
 * Class Reference
 * @package Genkgo\Camt\DTO
 */
class Reference
{
    /**
     * @var string|null
     */
    private $messageId;

    /**
     * @var string|null
     */
    private $accountServiceReference;

    /**
     * @var string|null
     */
    private $paymentInformationId;

    /**
     * @var string|null
     */
    private $instructionId;

    /**
     * @var string|null
     */
    private $endToEndId;

    /**
     * @var string|null
     */
    private $transactionId;

    /**
     * @var string|null
     */
    private $mandateId;

    /**
     * @var string|null
     */
    private $chequeNumber;

    /**
     * @var string|null
     */
    private $clearingSystemReference;

    /**
     * @var string|null
     */
    private $accountOwnerTransactionId;

    /**
     * @var string|null
     */
    private $accountServicerTransactionId;

    /**
     * @var string|null
     */
    private $marketInfrastructureTransactionId;

    /**
     * @var string|null
     */
    private $processingId;

    /**
     * @var ProprietaryReference[]
     */
    private $proprietaries = [];

    /**
     * @return string|null
     */
    public function getMessageId()
    {
        return $this->messageId;
    }

    /**
     * @param null|string $messageId
     *
     * @return Reference
     */
    public function setMessageId($messageId)
    {
        $this->messageId = $messageId;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAccountServiceReference()
    {
        return $this->accountServiceReference;
    }

    /**
     * @param null|string $accountServiceReference
     *
     * @return Reference
     */
    public function setAccountServiceReference($accountServiceReference)
    {
        $this->accountServiceReference = $accountServiceReference;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPaymentInformationId()
    {
        return $this->paymentInformationId;
    }

    /**
     * @param null|string $paymentInformationId
     *
     * @return Reference
     */
    public function setPaymentInformationId($paymentInformationId)
    {
        $this->paymentInformationId = $paymentInformationId;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getInstructionId()
    {
        return $this->instructionId;
    }

    /**
     * @param null|string $instructionId
     *
     * @return Reference
     */
    public function setInstructionId($instructionId)
    {
        $this->instructionId = $instructionId;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEndToEndId()
    {
        return $this->endToEndId;
    }

    /**
     * @param null|string $endToEndId
     *
     * @return Reference
     */
    public function setEndToEndId($endToEndId)
    {
        $this->endToEndId = $endToEndId;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * @param null|string $transactionId
     *
     * @return Reference
     */
    public function setTransactionId($transactionId)
    {
        $this->transactionId = $transactionId;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getMandateId()
    {
        return $this->mandateId;
    }

    /**
     * @param null|string $mandateId
     *
     * @return Reference
     */
    public function setMandateId($mandateId)
    {
        $this->mandateId = $mandateId;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getChequeNumber()
    {
        return $this->chequeNumber;
    }

    /**
     * @param null|string $chequeNumber
     *
     * @return Reference
     */
    public function setChequeNumber($chequeNumber)
    {
        $this->chequeNumber = $chequeNumber;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getClearingSystemReference()
    {
        return $this->clearingSystemReference;
    }

    /**
     * @param null|string $clearingSystemReference
     *
     * @return Reference
     */
    public function setClearingSystemReference($clearingSystemReference)
    {
        $this->clearingSystemReference = $clearingSystemReference;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAccountOwnerTransactionId()
    {
        return $this->accountOwnerTransactionId;
    }

    /**
     * @param null|string $accountOwnerTransactionId
     *
     * @return Reference
     */
    public function setAccountOwnerTransactionId($accountOwnerTransactionId)
    {
        $this->accountOwnerTransactionId = $accountOwnerTransactionId;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAccountServicerTransactionId()
    {
        return $this->accountServicerTransactionId;
    }

    /**
     * @param null|string $accountServicerTransactionId
     *
     * @return Reference
     */
    public function setAccountServicerTransactionId($accountServicerTransactionId)
    {
        $this->accountServicerTransactionId = $accountServicerTransactionId;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getMarketInfrastructureTransactionId()
    {
        return $this->marketInfrastructureTransactionId;
    }

    /**
     * @param null|string $marketInfrastructureTransactionId
     *
     * @return Reference
     */
    public function setMarketInfrastructureTransactionId($marketInfrastructureTransactionId)
    {
        $this->marketInfrastructureTransactionId = $marketInfrastructureTransactionId;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getProcessingId()
    {
        return $this->processingId;
    }

    /**
     * @param null|string $processingId
     *
     * @return Reference
     */
    public function setProcessingId($processingId)
    {
        $this->processingId = $processingId;

        return $this;
    }

    /**
     * @param ProprietaryReference $proprietary
     *
     * @return Reference
     */
    public function addProprietary(ProprietaryReference $proprietary)
    {
        $this->proprietaries[] = $proprietary;

        return $this;
    }

    /**
     * @return ProprietaryReference[]
     */
    public function getProprietaries()
    {
        return $this->proprietaries;
    }
}
