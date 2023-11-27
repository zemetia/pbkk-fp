<?php

namespace App\Core\Application\Service\GetArticle;

use Exception;
use App\Exceptions\UserException;
use App\Core\Domain\Models\User\User;
use App\Core\Domain\Models\Article\Article;
use App\Core\Domain\Models\CoAuthor\CoAuthor;
use App\Core\Application\Service\PaginationResponse;
use App\Core\Domain\Repository\UserRepositoryInterface;
use App\Core\Domain\Repository\ArticleRepositoryInterface;
use App\Core\Domain\Repository\CoAuthorRepositoryInterface;
use App\Core\Application\Service\GetArticle\GetArticleResponse;

class GetArticleService
{
    private ArticleRepositoryInterface $article_repository;
    private UserRepositoryInterface $user_repository;
    private CoAuthorRepositoryInterface $co_author_repository;

    /**
     * @param ArticleRepositoryInterface $article_repository
     * @param UserRepositoryInterface $user_repository
     * @param CoAuthorRepositoryInterface $co_author_repository
     */
    public function __construct(ArticleRepositoryInterface $article_repository, UserRepositoryInterface $user_repository, CoAuthorRepositoryInterface $co_author_repository)
    {
        $this->article_repository = $article_repository;
        $this->user_repository = $user_repository;
        $this->co_author_repository = $co_author_repository;
    }

    public function unpackAuthors(User $user): array
    {
        return array([
            "name" => $user->getName(),
            "username" => $user->getUsername(),
            "photo" => $user->getProfilePhotoUrl(),
            "description" => $user->getDescription()
        ]);
    }

    /**
     * @throws Exception
     */
    public function execute(GetArticleRequest $request)
    {
        $article = $this->article_repository->findByUsernameAndSlug($request->getUsername(), $request->getSlug());
        if (!$article || $article->getVisibility()->value == 'private' || $article->getVisibility()->value == 'private') {
            UserException::throw("Artikel tidak ditemukan", 1006, 404);
        }

        $author = $this->user_repository->find($article->getAuthorId());
        $coauthors = $this->co_author_repository->getByArticleId($article->getId());

        $coauthors_unpack = array_map(function (User $user) {
            return $this->unpackAuthors($user);
        }, $coauthors);

        return new GetArticleResponse(
            $article,
            $this->unpackAuthors($author),
            $coauthors_unpack
        );
    }
}
