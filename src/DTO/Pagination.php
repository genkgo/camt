<?php

declare(strict_types=1);

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

    public function __construct(string $pageNumber, bool $lastPage)
    {
        $this->pageNumber = $pageNumber;
        $this->lastPage = $lastPage;
    }

    public function getPageNumber(): string
    {
        return $this->pageNumber;
    }

    public function isLastPage(): bool
    {
        return $this->lastPage;
    }
}
