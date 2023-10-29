<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\Article\Article;
use App\Core\Domain\Models\Article\ArticleId;

interface ArticleRepositoryInterface
{
    public function persist(Article $article): void;

    public function delete(ArticleId $id): void;

    public function find(ArticleId $id): ?Article;

    public function getWithPagination(int $page, int $per_page): array;
}
