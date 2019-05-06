<?php

namespace Genkgo\Camt\DTO;

/**
 * Class ProprietaryAccount
 * @package Genkgo\Camt
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
