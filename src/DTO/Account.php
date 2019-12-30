<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

/**
 * Class Account
 * @package Genkgo\Camt\DTO
 */
abstract class Account
{
    /**
     * @return string
     */
    abstract public function getIdentification(): string;
}
