<?php

namespace Genkgo\Camt\DTO;

/**
 * Class Reference
 * @package Genkgo\Camt\DTO
 */
class Reference
{
    /**
     * @var null|string
     */
    private $messageId;

    /**
     * @var null|string
     */
    private $accountServicerReference;

    /**
     * @var null|string
     */
    private $paymentInformationId;

    /**
     * @var null|string
     */
    private $instructionId;

    /**
     * @var null|string
     */
    private $endToEndId;

    /**
     * @var null|string
     */
    private $transactionId;

    /**
     * @var null|string
     */
    private $mandateId;

    /**
     * @var null|string
     */
    private $chequeNumber;

    /**
     * @var null|string
     */
    private $clearingSystemReference;

    /**
     * @var null|string
     */
    private $accountOwnerTransactionId;

    /**
     * @var null|string
     */
    private $accountServicerTransactionId;

    /**
     * @var null|string
     */
    private $marketInfrastructureTransactionId;

    /**
     * @var null|string
     */
    private $processingId;

    /**
     * @var ProprietaryReference[]
     */
    private $proprietaries = [];

    /**
     * @return null|string
     */
    public function getMessageId(): ?string
    {
        return $this->messageId;
    }

    /**
     * @param null|string $messageId
     *
     * @return Reference
     */
    public function setMessageId(?string $messageId): self
    {
        $this->messageId = $messageId;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getAccountServicerReference(): ?string
    {
        return $this->accountServicerReference;
    }

    /**
     * @param null|string $accountServicerReference
     *
     * @return Reference
     */
    public function setAccountServicerReference(?string $accountServicerReference): self
    {
        $this->accountServicerReference = $accountServicerReference;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPaymentInformationId(): ?string
    {
        return $this->paymentInformationId;
    }

    /**
     * @param null|string $paymentInformationId
     *
     * @return Reference
     */
    public function setPaymentInformationId(?string $paymentInformationId): self
    {
        $this->paymentInformationId = $paymentInformationId;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getInstructionId(): ?string
    {
        return $this->instructionId;
    }

    /**
     * @param null|string $instructionId
     *
     * @return Reference
     */
    public function setInstructionId(?string $instructionId): self
    {
        $this->instructionId = $instructionId;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getEndToEndId(): ?string
    {
        return $this->endToEndId;
    }

    /**
     * @param null|string $endToEndId
     *
     * @return Reference
     */
    public function setEndToEndId(?string $endToEndId): self
    {
        $this->endToEndId = $endToEndId;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getTransactionId(): ?string
    {
        return $this->transactionId;
    }

    /**
     * @param null|string $transactionId
     *
     * @return Reference
     */
    public function setTransactionId(?string $transactionId): self
    {
        $this->transactionId = $transactionId;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getMandateId(): ?string
    {
        return $this->mandateId;
    }

    /**
     * @param null|string $mandateId
     *
     * @return Reference
     */
    public function setMandateId(?string $mandateId): self
    {
        $this->mandateId = $mandateId;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getChequeNumber(): ?string
    {
        return $this->chequeNumber;
    }

    /**
     * @param null|string $chequeNumber
     *
     * @return Reference
     */
    public function setChequeNumber(?string $chequeNumber): self
    {
        $this->chequeNumber = $chequeNumber;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getClearingSystemReference(): ?string
    {
        return $this->clearingSystemReference;
    }

    /**
     * @param null|string $clearingSystemReference
     *
     * @return Reference
     */
    public function setClearingSystemReference(?string $clearingSystemReference): self
    {
        $this->clearingSystemReference = $clearingSystemReference;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getAccountOwnerTransactionId(): ?string
    {
        return $this->accountOwnerTransactionId;
    }

    /**
     * @param null|string $accountOwnerTransactionId
     *
     * @return Reference
     */
    public function setAccountOwnerTransactionId(?string $accountOwnerTransactionId): self
    {
        $this->accountOwnerTransactionId = $accountOwnerTransactionId;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getAccountServicerTransactionId(): ?string
    {
        return $this->accountServicerTransactionId;
    }

    /**
     * @param null|string $accountServicerTransactionId
     *
     * @return Reference
     */
    public function setAccountServicerTransactionId(?string $accountServicerTransactionId): self
    {
        $this->accountServicerTransactionId = $accountServicerTransactionId;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getMarketInfrastructureTransactionId(): ?string
    {
        return $this->marketInfrastructureTransactionId;
    }

    /**
     * @param null|string $marketInfrastructureTransactionId
     *
     * @return Reference
     */
    public function setMarketInfrastructureTransactionId(?string $marketInfrastructureTransactionId): self
    {
        $this->marketInfrastructureTransactionId = $marketInfrastructureTransactionId;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getProcessingId(): ?string
    {
        return $this->processingId;
    }

    /**
     * @param null|string $processingId
     *
     * @return Reference
     */
    public function setProcessingId(?string $processingId): self
    {
        $this->processingId = $processingId;

        return $this;
    }

    /**
     * @param ProprietaryReference $proprietary
     *
     * @return Reference
     */
    public function addProprietary(ProprietaryReference $proprietary): self
    {
        $this->proprietaries[] = $proprietary;

        return $this;
    }

    /**
     * @return ProprietaryReference[]
     */
    public function getProprietaries(): array
    {
        return $this->proprietaries;
    }
}
