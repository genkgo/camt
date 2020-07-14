<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

/**
 * Interface RelatedPartyTypeInterface
 */
interface RelatedPartyTypeInterface
{
    public function setAddress(Address $address): void;

    public function getAddress(): ?Address;

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
