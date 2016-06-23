<?php

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
     * @param MessageFormatInterface $messageFormat
     */
    public function addMessageFormat(MessageFormatInterface $messageFormat)
    {
        $this->messageFormats[] = $messageFormat;
    }

    /**
     * @return MessageFormatInterface[]
     */
    public function getMessageFormats()
    {
        return $this->messageFormats;
    }

    /**
     * @return static
     */
    public static function getDefault()
    {
        $config = new static;
        $config->addMessageFormat(new Camt052\MessageFormat\V01());
        $config->addMessageFormat(new Camt052\MessageFormat\V04());
        $config->addMessageFormat(new Camt053\MessageFormat\V02());
        $config->addMessageFormat(new Camt053\MessageFormat\V03());
        $config->addMessageFormat(new Camt053\MessageFormat\V04());
        $config->addMessageFormat(new Camt054\MessageFormat\V02());
        $config->addMessageFormat(new Camt054\MessageFormat\V04());

        return $config;
    }
}
