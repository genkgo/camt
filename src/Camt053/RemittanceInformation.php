<?php
namespace Genkgo\Camt\Camt053;

/**
 * Class RemittanceInformation
 * @package Genkgo\Camt\Camt053
 */
class RemittanceInformation {

    /**
     * @var string
     */
    private $message;

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param $message
     * @return static
     */
    public static function fromUnstructured ($message) {
        $information = new static;
        $information->message = $message;
        return $information;
    }

}