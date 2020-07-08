<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

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

    public function getMessageId(): ?string
    {
        return $this->messageId;
    }

    public function setMessageId(?string $messageId): self
    {
        $this->messageId = $messageId;

        return $this;
    }

    public function getAccountServicerReference(): ?string
    {
        return $this->accountServicerReference;
    }

    public function setAccountServicerReference(?string $accountServicerReference): self
    {
        $this->accountServicerReference = $accountServicerReference;

        return $this;
    }

    public function getPaymentInformationId(): ?string
    {
        return $this->paymentInformationId;
    }

    public function setPaymentInformationId(?string $paymentInformationId): self
    {
        $this->paymentInformationId = $paymentInformationId;

        return $this;
    }

    public function getInstructionId(): ?string
    {
        return $this->instructionId;
    }

    public function setInstructionId(?string $instructionId): self
    {
        $this->instructionId = $instructionId;

        return $this;
    }

    public function getEndToEndId(): ?string
    {
        return $this->endToEndId;
    }

    public function setEndToEndId(?string $endToEndId): self
    {
        $this->endToEndId = $endToEndId;

        return $this;
    }

    public function getTransactionId(): ?string
    {
        return $this->transactionId;
    }

    public function setTransactionId(?string $transactionId): self
    {
        $this->transactionId = $transactionId;

        return $this;
    }

    public function getMandateId(): ?string
    {
        return $this->mandateId;
    }

    public function setMandateId(?string $mandateId): self
    {
        $this->mandateId = $mandateId;

        return $this;
    }

    public function getChequeNumber(): ?string
    {
        return $this->chequeNumber;
    }

    public function setChequeNumber(?string $chequeNumber): self
    {
        $this->chequeNumber = $chequeNumber;

        return $this;
    }

    public function getClearingSystemReference(): ?string
    {
        return $this->clearingSystemReference;
    }

    public function setClearingSystemReference(?string $clearingSystemReference): self
    {
        $this->clearingSystemReference = $clearingSystemReference;

        return $this;
    }

    public function getAccountOwnerTransactionId(): ?string
    {
        return $this->accountOwnerTransactionId;
    }

    public function setAccountOwnerTransactionId(?string $accountOwnerTransactionId): self
    {
        $this->accountOwnerTransactionId = $accountOwnerTransactionId;

        return $this;
    }

    public function getAccountServicerTransactionId(): ?string
    {
        return $this->accountServicerTransactionId;
    }

    public function setAccountServicerTransactionId(?string $accountServicerTransactionId): self
    {
        $this->accountServicerTransactionId = $accountServicerTransactionId;

        return $this;
    }

    public function getMarketInfrastructureTransactionId(): ?string
    {
        return $this->marketInfrastructureTransactionId;
    }

    public function setMarketInfrastructureTransactionId(?string $marketInfrastructureTransactionId): self
    {
        $this->marketInfrastructureTransactionId = $marketInfrastructureTransactionId;

        return $this;
    }

    public function getProcessingId(): ?string
    {
        return $this->processingId;
    }

    public function setProcessingId(?string $processingId): self
    {
        $this->processingId = $processingId;

        return $this;
    }

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
