<?php

namespace App\Core\Domain\Models\Article;

use App\Core\Domain\Models\User\UserId;

class Article
{
    private ArticleId $id;
    private UserId $author_id;
    private ArticleVisibility $visibility;
    private string $title;
    private string $description;
    private string $content;
    private string $url;
    private string $image_url;
    private string $created_at;
    private string $updated_at;
    private array $tags;
    public function __construct(ArticleId $id, UserId $author_id, ArticleVisibility $visibility, string $title, string $description, string $content, string $url, string $image_url, string $created_at, string $updated_at, array $tags)
    {
        $this->id = $id;
        $this->author_id = $author_id;
        $this->visibility = $visibility;
        $this->title = $title;
        $this->description = $description;
        $this->content = $content;
        $this->url = $url;
        $this->image_url = $image_url;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->tags = $tags;
    }

    public static function create(UserId $author_id, ArticleVisibility $visibility, string $title, string $description, string $content, string $url, string $image_url, string $created_at, string $updated_at, array $tags): self
    {
        return new self(
            ArticleId::generate(),
            $author_id,
            $visibility,
            $title,
            $description,
            $content,
            $url,
            $image_url,
            $created_at,
            $updated_at,
            $tags
        );
    }
}
