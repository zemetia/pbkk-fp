<?php

namespace App\Core\Application\Service\DeleteArticle;

use Exception;
use App\Exceptions\UserException;
use App\Core\Domain\Models\User\UserId;
use App\Core\Domain\Models\Article\ArticleId;
use App\Core\Domain\Repository\UserRepositoryInterface;
use App\Core\Domain\Repository\ArticleRepositoryInterface;
use App\Core\Domain\Repository\CoAuthorRepositoryInterface;
use App\Core\Application\Service\DeleteArticle\DeleteArticleRequest;

class DeleteArticleService
{
    private ArticleRepositoryInterface $article_repository;
    private CoAuthorRepositoryInterface $co_author_repository;

    /**
     * @param ArticleRepositoryInterface $article_repository
     * @param CoAuthorRepositoryInterface $co_author_repository
     */

    public function __construct(ArticleRepositoryInterface $article_repository, CoAuthorRepositoryInterface $co_author_repository)
    {
        $this->article_repository = $article_repository;
        $this->co_author_repository = $co_author_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(DeleteArticleRequest $request, UserId $user_id)
    {
        $article = $this->article_repository->findByUsernameAndSlug($request->getUsername(), $request->getSlug());
        if (!$article) {
            UserException::throw("Artikel tidak ditemukan", 1006, 404);
        }
        $is_coauthor = $this->co_author_repository->isUserCoAuthoredArticle($user_id, $article->getId());
        if (!$is_coauthor || $user_id != $article->getAuthorId()) {
            UserException::throw("User tidak dapat melakukan delete", 1006, 403);
        }
        $this->$this->article_repository->delete($article->getId());
    }
}
