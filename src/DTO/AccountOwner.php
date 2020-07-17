<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

class AccountOwner
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var null|\Genkgo\Camt\DTO\Address
     */
    private $address;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
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
}
