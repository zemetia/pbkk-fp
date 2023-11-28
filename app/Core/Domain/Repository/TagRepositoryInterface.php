<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\Tag\Tag;
use App\Core\Domain\Models\Tag\TagId;
use App\Core\Domain\Models\Tag\TagToArticle;
use App\Core\Domain\Models\Article\ArticleId;
use App\Core\Domain\Models\Tag\TagToArticleId;

interface TagRepositoryInterface
{
    /**
     * @param string $id
     * @return Tag[]
     */

    public function persist(string $tag, ArticleId $articleId): void;

    public function deleteTag(int $tag): void;

    public function deleteTagToArticle(TagToArticleId $id): void;

    public function getAllUniqueTags(): array;

    public function getByArticleId(ArticleId $articleId): array;

    public function find(int $id): ?Tag;
}
