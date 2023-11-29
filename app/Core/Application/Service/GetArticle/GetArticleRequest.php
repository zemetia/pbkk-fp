<?php

namespace App\Core\Application\Service\GetArticle;

class GetArticleRequest
{
    private string $username;
    private string $slug;

    /**
     * @param string $username
     * @param string $slug
     */
    public function __construct(string $username, string $slug)
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
    public function getSlug(): string
    {
        return $this->slug;
    }
}
