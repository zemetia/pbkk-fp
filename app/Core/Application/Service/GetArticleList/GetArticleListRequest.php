<?php

namespace App\Core\Application\Service\GetArticleList;

class GetArticleListRequest
{
    private int $page;
    private int $per_page;
    private ?string $sort;
    private ?string $sort_type;
    private ?array $tags;
    private ?string $search;


    /**
     * @param int $page
     * @param int $per_page
     * @param string|null $sort
     * @param string|null $sort_type
     * @param string|null $tags
     * @param string|null $search
     */
    public function __construct(int $page, int $per_page, ?string $sort, ?string $sort_type, ?array $tags, ?string $search)
    {
        $this->page = $page;
        $this->per_page = $per_page;
        $this->sort = $sort;
        $this->sort_type = $sort_type;
        $this->tags = $tags;
        $this->search = $search;
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function getPerPage(): int
    {
        return $this->per_page;
    }

    /**
     * @return string
     */
    public function getSort(): ?string
    {
        return $this->sort;
    }

    /**
     * @return string
     */
    public function getType(): ?string
    {
        return $this->sort_type;
    }

    /**
     * @return array
     */
    public function getTags(): ?array
    {
        return $this->tags;
    }

    /**
     * @return string
     */
    public function getSearch(): ?string
    {
        return $this->search;
    }
}
