<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

abstract class Account
{
    /**
     * @var null|\Genkgo\Camt\DTO\AccountOwner
     */
    private $owner;

    /**
     * @var null|\Genkgo\Camt\DTO\AccountServicer
     */
    private $servicer;

    /**
     * @var null|\Money\Currency
     */
    private $currency;

    abstract public function getIdentification(): string;

    /**
     * @return null|\Genkgo\Camt\DTO\AccountOwner
     */
    public function getOwner(): ?AccountOwner
    {
        return $this->owner;
    }

    /**
     * @param \Genkgo\Camt\DTO\AccountOwner $owner
     */
    public function setOwner(AccountOwner $owner): void
    {
        $this->owner = $owner;
    }

    /**
     * @return null|\Genkgo\Camt\DTO\AccountServicer
     */
    public function getServicer(): ?AccountServicer
    {
        return $this->servicer;
    }

    /**
     * @param \Genkgo\Camt\DTO\AccountServicer $servicer
     */
    public function setServicer(AccountServicer $servicer): void
    {
        $this->servicer = $servicer;
    }

    public function getCurrency(): ?\Money\Currency
    {
        return $this->currency;
    }

    public function setCurrency(\Money\Currency $currency): void
    {
        $this->currency = $currency;
    }
}
