<?php

namespace App\Core\Application\Service\GetArticle;

use JsonSerializable;
use App\Core\Domain\Models\Article\Article;

class GetArticleResponse implements JsonSerializable
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
            'id' => $this->article->getId(),
            'title' => $this->article->getTitle(),
            'description' => $this->article->getDescription(),
            'content' => $this->article->getContent(),
            'image_url' => $this->article->getImageUrl(),

            'author' => $this->author,
            'co_authors' => $this->coauthors

        ];
    }
}
