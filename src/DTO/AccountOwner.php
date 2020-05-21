<?php

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
     * @var \Genkgo\Camt\DTO\Address|null
     */
    private $address;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return \Genkgo\Camt\DTO\Address|null
     */
    public function getAddress(): ?\Genkgo\Camt\DTO\Address
    {
        return $this->address;
    }

    /**
     * @param \Genkgo\Camt\DTO\Address|null $address
     */
    public function setAddress(\Genkgo\Camt\DTO\Address $address): void
    {
        $this->address = $address;
    }
}