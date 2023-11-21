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

    public function delete(CoAuthorId $id): void;

    public function find(CoAuthorId $id): ?CoAuthor;

    public function getByArticleId(ArticleId $article_id): array;

    public function isUserCoAuthoredArticle(UserId $user_id, ArticleId $article_id): bool;
}
