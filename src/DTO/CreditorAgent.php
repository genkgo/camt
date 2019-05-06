<?php
namespace Genkgo\Camt\DTO;

class CreditorAgent implements RelatedAgentTypeInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $BIC;

    /**
     * CreditorAgent constructor.
     * @param string $name
     * @param string $BIC
     */
    public function __construct($name, $BIC)
    {
        $this->name = $name;
        $this->BIC = $BIC;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getBIC()
    {
        return $this->BIC;
    }

    /**
     * @param string $BIC
     */
    public function setBIC($BIC)
    {
        $this->BIC = $BIC;
    }
}
