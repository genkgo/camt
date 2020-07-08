<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

use DateTimeImmutable;

class GroupHeader
{
    /**
     * @var string
     */
    private $messageId;

    /**
     * @var DateTimeImmutable
     */
    private $createdOn;

    /**
     * @var null|string
     */
    private $additionalInformation;

    /**
     * @var null|Recipient
     */
    private $messageRecipient;

    /**
     * @var null|Pagination
     */
    private $pagination;

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
