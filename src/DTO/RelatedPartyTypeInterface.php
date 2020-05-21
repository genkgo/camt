<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

/**
 * Interface RelatedPartyTypeInterface
 *
 * @package Genkgo\Camt\DTO
 */
interface RelatedPartyTypeInterface
{
    /**
     * @param Address $address
     */
    public function setAddress(Address $address): void;

    /**
     * @return null|Address
     */
    public function getAddress(): ?Address;

    /**
     * @return null|string
     */
    public function getName(): ?string;

    /**
     * @return null|string
     */
    public function getId(): ?string;

    /**
     * @param string $id
     * @return void
     */
    public function setId(string $id): void;

    /**
     * @return string|null
     */
    public function getTypeName(): ?string;

    /**
     * @param string|null $typeName
     */
    public function setTypeName(?string $typeName): void;
}
