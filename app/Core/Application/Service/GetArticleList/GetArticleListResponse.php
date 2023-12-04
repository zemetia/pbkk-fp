<?php

namespace App\Core\Application\Service\GetArticleList;

use JsonSerializable;
use App\Core\Domain\Models\Article\Article;

class GetArticleListResponse implements JsonSerializable
{
    private Article $article;
    private array $author;
    private array $coauthors;

    /**
     * @param Article $article
     * @param array $author;
     * @param array $coauthors;
     */
    public function __construct(Article $article, array $author, array $coauthors)
    {
        $this->article = $article;
        $this->author = $author;
        $this->coauthors = $coauthors;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->article->getId()->toString(),
            'title' => $this->article->getTitle(),
            'description' => $this->article->getDescription(),
            'image_url' => $this->article->getImageUrl(),
            'url' => $this->article->getUrl(),
            'created_at' => $this->article->getCreatedAt(),

            'author' => $this->author,
            'co_authors' => $this->coauthors
        ];
    }
}
