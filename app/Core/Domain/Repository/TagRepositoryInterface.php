<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\Tag\Tag;
use App\Core\Domain\Models\Tag\TagId;
use App\Core\Domain\Models\Article\ArticleId;
use App\Core\Domain\Models\Tag\TagToArticle;

interface TagRepositoryInterface
{
    /**
     * @param string $id
     * @return Tag[]
     */

    public function persist(string $tag, ArticleId $articleId): void;

    public function delete(Tag $tag): void;

    public function deleteTagToArticle(TagToArticle $toa): void;

    public function getAllUniqueTags(): array;

    public function getByArticleId(ArticleId $articleId): array;

    public function find(int $id): ?Tag;
}
