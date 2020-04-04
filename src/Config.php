<?php

declare(strict_types=1);

namespace Genkgo\Camt;

use Genkgo\Camt\Camt052;
use Genkgo\Camt\Camt053;
use Genkgo\Camt\Camt054;

/**
 * Class Config
 * @package Genkgo\Camt
 */
class Config
{
    /**
     * @var MessageFormatInterface[]
     */
    private $messageFormats = [];

    /**
     * @var bool
     */
    private $xsdValidation = true;

    /**
     * @param MessageFormatInterface $messageFormat
     */
    public function addMessageFormat(MessageFormatInterface $messageFormat): void
    {
        $this->messageFormats[] = $messageFormat;
    }

    /**
     * @return MessageFormatInterface[]
     */
    public function getMessageFormats(): array
    {
        return $this->messageFormats;
    }

    public function disableXsdValidation(): void
    {
        $this->xsdValidation = false;
    }

    /**
     * @return bool
     */
    public function getXsdValidation(): bool
    {
        return $this->xsdValidation;
    }

    /**
     * @return self
     */
    public static function getDefault(): Config
    {
        $config = new self();
        $config->addMessageFormat(new Camt052\MessageFormat\V01());
        $config->addMessageFormat(new Camt052\MessageFormat\V04());
        $config->addMessageFormat(new Camt052\MessageFormat\V06());
        $config->addMessageFormat(new Camt053\MessageFormat\V02());
        $config->addMessageFormat(new Camt053\MessageFormat\V03());
        $config->addMessageFormat(new Camt053\MessageFormat\V04());
        $config->addMessageFormat(new Camt054\MessageFormat\V02());
        $config->addMessageFormat(new Camt054\MessageFormat\V04());

        return $config;
    }
}
