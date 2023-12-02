<?php

namespace App\Core\Application\Service\DeleteCoAuthor;

use Exception;
use App\Exceptions\UserException;
use App\Core\Domain\Models\User\UserId;
use App\Core\Domain\Models\Article\ArticleId;
use App\Core\Domain\Models\CoAuthor\CoAuthorId;
use App\Core\Domain\Repository\ArticleRepositoryInterface;
use App\Core\Domain\Repository\CoAuthorRepositoryInterface;

class DeleteCoAuthorService
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
    public function execute(DeleteCoAuthorRequest $request, UserId $user_id)
    {
        $article_id = new ArticleId($request->getArticleId());
        $article = $this->article_repository->find($article_id);
        if (!$article) {
            UserException::throw("Artikel tidak ditemukan", 1006, 404);
        }
        $is_coauthor = $this->co_author_repository->isUserCoAuthoredArticle($user_id, $article->getId());
        if (!$is_coauthor && $user_id != $article->getAuthorId()) {
            UserException::throw("User tidak dapat melakukan remove co-Author", 1006, 403);
        }

        $co_author = $this->co_author_repository->find(new CoAuthorId($request->getCoAuthorId()));
        $this->$this->co_author_repository->delete($co_author->getId());
    }
}
