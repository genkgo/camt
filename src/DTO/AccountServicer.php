<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

class AccountServicer
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $bic;

    /**
     * @var string
     */
    private $name;

    /**
     * @var \Genkgo\Camt\DTO\Address
     */
    private $address;

    /**
     * @var string
     */
    private $schmeNm;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getBic(): ?string
    {
        return $this->bic;
    }

    public function setBic(string $bic): void
    {
        $this->bic = $bic;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return null|\Genkgo\Camt\DTO\Address
     */
    public function getAddress(): ?Address
    {
        return $this->address;
    }

    /**
     * @param \Genkgo\Camt\DTO\Address $address
     */
    public function setAddress(Address $address): void
    {
        $this->address = $address;
    }

    public function getSchmeNm(): ?string
    {
        return $this->schmeNm;
    }

    public function setSchmeNm(string $schmeNm): void
    {
        $this->schmeNm = $schmeNm;
    }
}
