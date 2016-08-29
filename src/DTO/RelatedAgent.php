<?php
namespace Genkgo\Camt\DTO;


class RelatedAgent
{
    /**
     * @var RelatedAgentTypeInterface
     */
    private $relatedAgentDetails;

    /**
     * RelatedAgent constructor.
     * @param RelatedAgentTypeInterface $relatedAgentDetails
     */
    public function __construct(RelatedAgentTypeInterface $relatedAgentDetails)
    {
        $this->relatedAgentDetails = $relatedAgentDetails;
    }

    /**
     * @return RelatedAgentTypeInterface
     */
    public function getRelatedAgentType()
    {
        return $this->relatedAgentDetails;
    }
}