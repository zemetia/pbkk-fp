<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\User\UserId;
use App\Core\Domain\Models\Article\ArticleId;
use App\Core\Domain\Models\CoAuthor\CoAuthor;
use App\Core\Domain\Models\CoAuthor\CoAuthorId;

interface CoAuthorRepositoryInterface
{
    /**
     * @param string $id
     * @return CoAuthor[]
     */
    public function persist(CoAuthor $coauthor): void;

    public function delete(CoAuthor $coauthor): void;

    public function find(CoAuthorId $id): ?CoAuthor;

    public function getByArticleId(ArticleId $article_id): array;

    public function isUserCoAuthoredArticle(UserId $userId, ArticleId $article_id): bool;
}
