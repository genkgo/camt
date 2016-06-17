<?php

namespace Genkgo\Camt\DTO;

class Pagination
{
    /**
     * @var string
     */
    private $pageNumber;

    /**
     * @var bool
     */
    private $lastPage;

    public function __construct($pageNumber, $lastPage)
    {
        $this->pageNumber = $pageNumber;
        $this->lastPage   = $lastPage;
    }

    /**
     * @return string
     */
    public function getPageNumber()
    {
        return $this->pageNumber;
    }

    /**
     * @return bool
     */
    public function isLastPage()
    {
        return $this->lastPage;
    }
}
