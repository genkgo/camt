<?php

namespace Genkgo\Camt\Camt052\DTO;

use Genkgo\Camt\DTO\Account;

/**
 * Class ProprietaryAccount
 * @package Genkgo\Camt\Camt052
 */
class ProprietaryAccount extends Account
{
    /**
     * @var string
     */
    private $id;

    /**
     * @param string $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return (string) $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentification()
    {
        return (string) $this->id;
    }
}
