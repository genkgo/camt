<?php

namespace Genkgo\Camt;

use Genkgo\Camt\Camt053\MessageFormat\Camt053V02;
use Genkgo\Camt\Camt053\MessageFormat\Camt053V03;

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
        $config->addMessageFormat(new Camt053V02());
        $config->addMessageFormat(new Camt053V03());
        return $config;
    }
}
