<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

abstract class Account
{
    abstract public function getIdentification(): string;
}
