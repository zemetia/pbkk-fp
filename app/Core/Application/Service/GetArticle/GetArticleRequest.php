<?php

namespace App\Core\Application\Service\GetArticle;

class GetArticleRequest
{
    private int $username;
    private int $slug;

    /**
     * @param int $username
     * @param int $slug
     */
    public function __construct(int $username, int $slug)
    {
        $this->username = $username;
        $this->slug = $slug;
    }

    /**
     * @return int
     */
    public function getUsername(): int
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
