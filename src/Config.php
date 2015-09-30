<?php
namespace Genkgo\Camt;

/**
 * Class Config
 * @package Genkgo\Camt
 */
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
    public static function getDefault () {
        $config = new static;
        $config->addMessageFormat(new Camt053\MessageFormat());
        $config->addMessageFormat(new Camt053V03\MessageFormat());
        return $config;
    }
}
