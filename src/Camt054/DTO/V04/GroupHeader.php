<?php

namespace Genkgo\Camt\Camt054\DTO\V04;

use Genkgo\Camt\DTO\GroupHeader as BaseGroupHeader;

class GroupHeader extends BaseGroupHeader
{
    /**
     * @var OriginalBusinessQuery|null
     */
    private $originalBusinessQuery;

    /**
     * @return OriginalBusinessQuery|null
     */
    public function getOriginalBusinessQuery()
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
