<?php

namespace Genkgo\Camt\DTO;

/**
 * Class RemittanceInformation
 * @package Genkgo\Camt\DTO
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
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

}
