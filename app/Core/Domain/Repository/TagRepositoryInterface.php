<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\Tag\Tag;
use App\Core\Domain\Models\Tag\TagId;
use App\Core\Domain\Models\Article\ArticleId;

interface TagRepositoryInterface
{
    /**
     * @param string $id
     * @return Tag[]
     */

    public function persist(Tag $tag): void;

    public function delete(Tag $tag): void;

    public function getAllUniqueTags(): array;

    public function getByArticleId(ArticleId $articleId): array;

    public function find(TagId $id): ?Tag;
}
