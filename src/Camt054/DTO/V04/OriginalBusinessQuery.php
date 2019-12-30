<?php

declare(strict_types=1);

namespace Genkgo\Camt\Camt054\DTO\V04;

use DateTimeImmutable;

class OriginalBusinessQuery
{
    /**
     * @var string
     */
    private $messageId;

    /**
     * @var null|string
     */
    private $messageNameId;

    /**
     * @var null|DateTimeImmutable
     */
    private $createdOn;

    /**
     * @param string $messageId
     */
    public function __construct(string $messageId)
    {
        $this->messageId = $messageId;
    }

    /**
     * @return string
     */
    public function getMessageId(): string
    {
        return $this->messageId;
    }

    /**
     * @return null|string
     */
    public function getMessageNameId(): ?string
    {
        return $this->messageNameId;
    }

    /**
     * @param string $messageNameId
     *
     * @return OriginalBusinessQuery
     */
    public function setMessageNameId(string $messageNameId): self
    {
        $this->messageNameId = $messageNameId;

        return $this;
    }

    /**
     * @param DateTimeImmutable $createdOn
     *
     * @return OriginalBusinessQuery
     */
    public function setCreatedOn(DateTimeImmutable $createdOn): self
    {
        $this->createdOn = $createdOn;

        return $this;
    }

    /**
     * @return null|DateTimeImmutable
     */
    public function getCreatedOn(): ?DateTimeImmutable
    {
        return $this->createdOn;
    }
}
