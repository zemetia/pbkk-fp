<?php

namespace App\Core\Application\Service\UpdateArticle;

use Exception;
use Illuminate\Support\Str;
use App\Exceptions\UserException;
use App\Core\Domain\Models\User\UserId;
use App\Core\Domain\Models\Article\Article;
use App\Core\Domain\Models\Article\ArticleVisibility;
use App\Core\Domain\Repository\ArticleRepositoryInterface;
use App\Core\Domain\Repository\CoAuthorRepositoryInterface;

class UpdateArticleService
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
    public function execute(UpdateArticleRequest $request, UserId $user_id)
    {
        $article = $this->article_repository->findByUsernameAndSlug($request->getUsername(), $request->getSlug());
        if (!$article) {
            UserException::throw("Artikel tidak ditemukan", 1006, 404);
        }
        $is_coauthor = $this->co_author_repository->isUserCoAuthoredArticle($user_id, $article->getId());
        if (!$is_coauthor || $user_id != $article->getAuthorId()) {
            UserException::throw("User tidak dapat melakukan update", 1006, 403);
        }

        $article = Article::create(
            $user_id,
            ArticleVisibility::from($request->getVisibility()),
            $request->getTitle(),
            $request->getDescription(),
            $request->getContent(),
            $article->getUrl(),
            $request->getImageUrl(),
        );

        $this->article_repository->persist($article);
    }
}
