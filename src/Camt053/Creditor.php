<?php
namespace Genkgo\Camt\Camt053;

/**
 * Class Creditor
 * @package Genkgo\Camt\Camt053
 */
class Creditor {

    /**
     * @var
     */
    private $name;
    /**
     * @var
     */
    private $address;

    /**
     * @param $name
     */
    public function __construct ($name) {
        $this->name = $name;
    }

    /**
     * @param Address $address
     */
    public function setAddress (Address $address) {
        $this->address = $address;
    }

    /**
     * @return Address|null
     */
    public function getAddress () {
        return $this->address;
    }

    /**
     * @return mixed
     */
    public function getName () {
        return $this->name;
    }

}