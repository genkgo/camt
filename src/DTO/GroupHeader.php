<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

use DateTimeImmutable;

class GroupHeader
{
    private string $messageId;

    private DateTimeImmutable $createdOn;

    private ?string $additionalInformation = null;

    private ?Recipient $messageRecipient = null;

    private ?Pagination $pagination = null;

    public function __construct(string $messageId, DateTimeImmutable $createdOn)
    {
        $this->messageId = $messageId;
        $this->createdOn = $createdOn;
    }

    public function getMessageId(): string
    {
        return $this->messageId;
    }

    public function getCreatedOn(): DateTimeImmutable
    {
        return $this->createdOn;
    }

    public function getAdditionalInformation(): ?string
    {
        return $this->additionalInformation;
    }

    public function setAdditionalInformation(string $additionalInformation): void
    {
        $this->additionalInformation = $additionalInformation;
    }

    public function getMessageRecipient(): ?Recipient
    {
        return $this->messageRecipient;
    }

    public function setMessageRecipient(Recipient $messageRecipient): void
    {
        $this->messageRecipient = $messageRecipient;
    }

    public function getPagination(): ?Pagination
    {
        return $this->pagination;
    }

    public function setPagination(?Pagination $pagination): void
    {
        $this->pagination = $pagination;
    }
}
