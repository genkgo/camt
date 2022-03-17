<?php

declare(strict_types=1);

namespace Genkgo\Camt\Camt054\DTO\V04;

use Genkgo\Camt\DTO\GroupHeader as BaseGroupHeader;

class GroupHeader extends BaseGroupHeader
{
    private ?OriginalBusinessQuery $originalBusinessQuery = null;

    public function getOriginalBusinessQuery(): ?OriginalBusinessQuery
    {
        return $this->originalBusinessQuery;
    }

    public function setOriginalBusinessQuery(OriginalBusinessQuery $originalBusinessQuery): self
    {
        $this->originalBusinessQuery = $originalBusinessQuery;

        return $this;
    }
}
