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

    public function getId(): ?string;

    public function setId(string $id): void;

    public function getTypeName(): ?string;

    public function setTypeName(?string $typeName): void;
}
