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

    /**
     * @param string $pageNumber
     * @param bool $lastPage
     */
    public function __construct(string $pageNumber, bool $lastPage)
    {
        $this->pageNumber = $pageNumber;
        $this->lastPage   = $lastPage;
    }

    /**
     * @return string
     */
    public function getPageNumber(): string
    {
        return $this->pageNumber;
    }

    /**
     * @return bool
     */
    public function isLastPage(): bool
    {
        return $this->lastPage;
    }
}
