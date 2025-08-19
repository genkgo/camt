<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

use Money\Money;

final class BatchInformation
{
    private ?string $msgId = null;
    private ?string $pmtInfId = null;
    private ?string $nbOfTxs = null;
    private ?Money $ttlAmt = null;
    private ?string $cdtDbtInd = null;

    public function getMessageId(): ?string
    {
        return $this->msgId;
    }

    public function setMessageId(?string $msgId): void
    {
        $this->msgId = $msgId;
    }

    public function getPaymentInformationId(): ?string
    {
        return $this->pmtInfId;
    }

    public function setPaymentInformationId(?string $pmtInfId): void
    {
        $this->pmtInfId = $pmtInfId;
    }

    public function getNumberOfTransactions(): ?string
    {
        return $this->nbOfTxs;
    }

    public function setNumberOfTransactions(?string $nbOfTxs): void
    {
        $this->nbOfTxs = $nbOfTxs;
    }

    public function getTotalAmount(): ?Money
    {
        return $this->ttlAmt;
    }

    public function setTotalAmount(?Money $amount): void
    {
        $this->ttlAmt = $amount;
    }

    public function getCreditDebitIndicator(): ?string
    {
        return $this->cdtDbtInd;
    }

    public function setCreditDebitIndicator(?string $cdtDbtInd): void
    {
        $this->cdtDbtInd = $cdtDbtInd;
    }
}
