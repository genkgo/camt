<?php

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
     * @var Pagination
     */
    private $pagination;


    /**
     * @param string $messageId
     * @param DateTimeImmutable $createdOn
     */
    public function __construct($messageId, DateTimeImmutable $createdOn)
    {
        $this->messageId = $messageId;
        $this->createdOn = $createdOn;
    }

    /**
     * @return string
     */
    public function getMessageId()
    {
        return $this->messageId;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreatedOn()
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
    public function setAdditionalInformation($additionalInformation)
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
    public function setMessageRecipient(Recipient $messageRecipient)
    {
        $this->messageRecipient = $messageRecipient;
    }

    /**
     * @return Pagination
     */
    public function getPagination()
    {
        return $this->pagination;
    }

    /**
     * @param Pagination $pagination
     */
    public function setPagination(Pagination $pagination)
    {
        $this->pagination = $pagination;
    }
}
