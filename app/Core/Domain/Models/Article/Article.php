<?php

namespace App\Core\Domain\Models\Article;

use App\Core\Domain\Models\User\UserId;

class Article
{
    private ArticleId $id;
    private UserId $authorId;
    private string $title;
    private string $description;
    private string $content;
    private string $url;
    private string $imageUrl;
    private string $createdAt;
    private string $updatedAt;
    private array $tags;
    public function __construct(ArticleId $id, UserId $authorId, string $title, string $description, string $content, string $url, string $imageUrl, string $createdAt, string $updatedAt, array $tags)
    {
        $this->id = $id;
        $this->authorId = $authorId;
        $this->title = $title;
        $this->description = $description;
        $this->content = $content;
        $this->url = $url;
        $this->imageUrl = $imageUrl;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->tags = $tags;
    }

    public static function create(UserId $authorId, string $title, string $description, string $content, string $url, string $imageUrl, string $createdAt, string $updatedAt, array $tags): self
    {
        return new self(
            ArticleId::generate(),
            $authorId,
            $title,
            $description,
            $content,
            $url,
            $imageUrl,
            $createdAt,
            $updatedAt,
            $tags
        );
    }
}
