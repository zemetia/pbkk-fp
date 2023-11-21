<?php

namespace App\Core\Domain\Models\Article;

use Illuminate\Support\Carbon;
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
    public function __construct(ArticleId $id, UserId $author_id, ArticleVisibility $visibility, string $title, string $description, string $content, string $url, string $image_url, string $created_at, string $updated_at)
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
    }

    public static function create(UserId $author_id, ArticleVisibility $visibility, string $title, string $description, string $content, string $url, string $image_url): self
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
            Carbon::now(),
            Carbon::now(),
        );
    }

    public function getId(): ArticleId
    {
        return $this->id;
    }

    public function getAuthorId(): UserId
    {
        return $this->author_id;
    }

    public function getVisibility(): ArticleVisibility
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

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getImageUrl(): string
    {
        return $this->image_url;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }
}
