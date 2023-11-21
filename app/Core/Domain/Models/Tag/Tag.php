<?php

namespace App\Core\Domain\Models\Tag;

use Illuminate\Support\Carbon;
use App\Core\Domain\Models\Article\ArticleId;

class Tag
{
    private TagId $id;
    private ArticleId $article_id;
    private string $tag_name;
    public function __construct(TagId $id, ArticleId $article_id, string $tag_name)
    {
        $this->id = $id;
        $this->article_id = $article_id;
        $this->tag_name = $tag_name;
    }

    public static function create(ArticleId $article_id, string $tag_name): self
    {
        return new self(
            TagId::generate(),
            $article_id,
            $tag_name
        );
    }

    public function getId(): TagId
    {
        return $this->id;
    }

    public function getArticleId(): ArticleId
    {
        return $this->article_id;
    }

    public function getTagName(): string
    {
        return $this->tag_name;
    }
}
