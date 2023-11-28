<?php

namespace App\Core\Domain\Models\Tag;

use App\Core\Domain\Models\Article\ArticleId;

class TagToArticle
{
    private TagToArticleId $id;
    private ArticleId $article_id;
    private int $tag_id;
    public function __construct(TagToArticleId $id, ArticleId $article_id, int $tag_id)
    {
        $this->id = $id;
        $this->article_id = $article_id;
        $this->tag_id = $tag_id;
    }

    public static function create(ArticleId $article_id, int $tag_id): self
    {
        return new self(
            TagToArticleId::generate(),
            $article_id,
            $tag_id
        );
    }

    public function getId(): TagToArticleId
    {
        return $this->id;
    }

    public function getArticleId(): ArticleId
    {
        return $this->article_id;
    }

    public function getTagId(): int
    {
        return $this->tag_id;
    }
}
