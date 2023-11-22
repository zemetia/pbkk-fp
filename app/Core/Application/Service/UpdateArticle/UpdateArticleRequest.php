<?php

namespace App\Core\Application\Service\UpdateArticle;

class UpdateArticleRequest
{
    private string $username;
    private string $slug;
    private string $visibility;
    private string $title;
    private string $description;
    private string $content;
    private string $image_url;
    /**
     * @param string $article_id
     */

    public function __construct(string $username, string $slug, string $visibility, string $title, string $description, string $content, string $image_url)
    {
        $this->username = $username;
        $this->slug = $slug;
        $this->visibility = $visibility;
        $this->title = $title;
        $this->description = $description;
        $this->content = $content;
        $this->image_url = $image_url;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getVisibility(): string
    {
        return $this->visibility;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getImageUrl(): string
    {
        return $this->image_url;
    }
}
