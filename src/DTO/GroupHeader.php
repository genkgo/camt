<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

use DateTimeImmutable;

/**
 * Class GroupHeader
 * @package Genkgo\Camt\DTO
 */
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


    /**
     * @param string $messageId
     * @param DateTimeImmutable $createdOn
     */
    public function __construct(string $messageId, DateTimeImmutable $createdOn)
    {
        $this->messageId = $messageId;
        $this->createdOn = $createdOn;
    }

    /**
     * @return string
     */
    public function getMessageId(): string
    {
        return $this->messageId;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreatedOn(): DateTimeImmutable
    {
        return $this->createdOn;
    }

    /**
     * @return null|string
     */
    public function getAdditionalInformation(): ?string
    {
        return $this->additionalInformation;
    }

    /**
     * @param string $additionalInformation
     */
    public function setAdditionalInformation(string $additionalInformation): void
    {
        $this->additionalInformation = $additionalInformation;
    }

    /**
     * @return null|Recipient
     */
    public function getMessageRecipient():?Recipient
    {
        return $this->messageRecipient;
    }

    /**
     * @param Recipient $messageRecipient
     */
    public function setMessageRecipient(Recipient $messageRecipient): void
    {
        $this->messageRecipient = $messageRecipient;
    }

    /**
     * @return null|Pagination
     */
    public function getPagination(): ?Pagination
    {
        return $this->pagination;
    }

    /**
     * @param null|Pagination $pagination
     */
    public function setPagination(?Pagination $pagination): void
    {
        $this->pagination = $pagination;
    }
}
