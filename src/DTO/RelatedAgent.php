<?php

declare(strict_types=1);

namespace Genkgo\Camt\DTO;

class RelatedAgent
{
    /**
     * @var RelatedAgentTypeInterface
     */
    private $relatedAgentDetails;

    /**
     * RelatedAgent constructor.
     */
    public function __construct(RelatedAgentTypeInterface $relatedAgentDetails)
    {
        $this->relatedAgentDetails = $relatedAgentDetails;
    }

    public function getRelatedAgentType(): RelatedAgentTypeInterface
    {
        return $this->relatedAgentDetails;
    }
}
