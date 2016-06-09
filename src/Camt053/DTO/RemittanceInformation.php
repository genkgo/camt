<?php

namespace Genkgo\Camt\Camt053\DTO;

/**
 * Class RemittanceInformation
 * @package Genkgo\Camt\Camt053
 */
class RemittanceInformation
{
    /**
     * @var string
     */
    private $message;

    /**
     * @var CreditorReferenceInformation
     */
    private $creditorReferenceInformation;

    /**
     * @param $message
     * @return static
     */
    public static function fromUnstructured($message)
    {
        $information = new static;
        $information->message = $message;
        return $information;
    }

    /**
     * @return CreditorReferenceInformation
     */
    public function getCreditorReferenceInformation()
    {
        return $this->creditorReferenceInformation;
    }

    /**
     * @param CreditorReferenceInformation $creditorReferenceInformation
     */
    public function setCreditorReferenceInformation($creditorReferenceInformation)
    {
        $this->creditorReferenceInformation = $creditorReferenceInformation;
        $this->message = $creditorReferenceInformation->getRef();
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }
}
