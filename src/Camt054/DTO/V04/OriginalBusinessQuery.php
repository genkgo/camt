<?php

declare(strict_types=1);

namespace Genkgo\Camt\Camt054\DTO\V04;

use DateTimeImmutable;

class OriginalBusinessQuery
{
    private string $messageId;

    private ?string $messageNameId = null;

    private ?DateTimeImmutable $createdOn = null;

    public function __construct(string $messageId)
    {
        $this->messageId = $messageId;
    }

    public function getMessageId(): string
    {
        return $this->messageId;
    }

    public function getMessageNameId(): ?string
    {
        return $this->messageNameId;
    }

    public function setMessageNameId(string $messageNameId): self
    {
        $this->messageNameId = $messageNameId;

        return $this;
    }

    public function setCreatedOn(DateTimeImmutable $createdOn): self
    {
        $this->createdOn = $createdOn;

        return $this;
    }

    public function getCreatedOn(): ?DateTimeImmutable
    {
        return $this->createdOn;
    }
}
