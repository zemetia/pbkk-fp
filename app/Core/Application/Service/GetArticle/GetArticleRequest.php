<?php

namespace App\Core\Application\Service\GetArticle;

class GetArticleRequest
{
    private string $username;
    private int $slug;

    /**
     * @param string $username
     * @param int $slug
     */
    public function __construct(string $username, int $slug)
    {
        $this->username = $username;
        $this->slug = $slug;
    }

    /**
     * @return int
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return int
     */
    public function getSlug(): int
    {
        return $this->slug;
    }
}
