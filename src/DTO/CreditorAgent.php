<?php
namespace Genkgo\Camt\DTO;


class CreditorAgent implements RelatedAgentTypeInterface
{
    /**
     * @var mixed
     */
    private $name;

    /**
     * @var mixed
     */
    private $BIC;

    /**
     * CreditorAgent constructor.
     * @param $name
     * @param $BIC
     */
    public function __construct($name, $BIC)
    {
        $this->name = $name;
        $this->BIC = $BIC;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getBIC()
    {
        return $this->BIC;
    }

    /**
     * @param mixed $BIC
     */
    public function setBIC($BIC)
    {
        $this->BIC = $BIC;
    }
}