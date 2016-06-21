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
     * @var string|null
     */
    private $additionalInformation;

    /**
     * @param $messageId
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
     * @return string|null
     */
    public function getAdditionalInformation()
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
}
