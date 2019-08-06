<?php

namespace Genkgo\Camt\Camt054\DTO\V04;

use Genkgo\Camt\DTO\GroupHeader as BaseGroupHeader;

class GroupHeader extends BaseGroupHeader
{
    /**
     * @var null|OriginalBusinessQuery
     */
    private $originalBusinessQuery;

    /**
     * @return null|OriginalBusinessQuery
     */
    public function getOriginalBusinessQuery(): ?OriginalBusinessQuery
    {
        return $this->originalBusinessQuery;
    }

    /**
     * @param OriginalBusinessQuery $originalBusinessQuery
     *
     * @return GroupHeader
     */
    public function setOriginalBusinessQuery(OriginalBusinessQuery $originalBusinessQuery)
    {
        $this->originalBusinessQuery = $originalBusinessQuery;

        return $this;
    }
}
