<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\Article\Article;

interface ArticleRepositoryInterface
{
    public function persist(Article $article): void;

    public function delete(int $id): void;

    public function find(int $id): ?Article;

    public function findLargestId(): ?int;

    public function getWithPagination(int $page, int $per_page): array;
}
