<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

/**
 * Interface RelatedPartyTypeInterface.
 */
interface RelatedPartyTypeInterface
{
    public function __construct(?string $name);

    public function setAddress(Address $address): void;

    public function getAddress(): ?Address;

    public function getName(): ?string;
}
