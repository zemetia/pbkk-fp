<?php

namespace App\Core\Application\Service\AddCoAuthor;

use Exception;
use Illuminate\Support\Str;
use App\Exceptions\UserException;
use App\Core\Domain\Models\User\UserId;
use App\Core\Domain\Models\Article\Article;
use App\Core\Domain\Models\Article\ArticleId;
use App\Core\Domain\Models\CoAuthor\CoAuthor;
use App\Core\Domain\Repository\ArticleRepositoryInterface;
use App\Core\Domain\Repository\CoAuthorRepositoryInterface;

class AddCoAuthorService
{
    private CoAuthorRepositoryInterface $co_author_repository;
    private ArticleRepositoryInterface $article_repository;

    /**
     * @param CoAuthorRepositoryInterface $co_author_repository
     */

    public function __construct(CoAuthorRepositoryInterface $co_author_repository, ArticleRepositoryInterface $article_repository)
    {
        $this->co_author_repository = $co_author_repository;
        $this->article_repository = $article_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(AddCoAuthorRequest $request, UserId $user_id)
    {
        $article_id = new ArticleId($request->getArticleId());
        $article = $this->article_repository->find($article_id);
        if (!$article) {
            UserException::throw("Artikel tidak ditemukan", 1006, 404);
        }

        $is_coauthor = $this->co_author_repository->isUserCoAuthoredArticle($user_id, $article->getId());
        if (!$is_coauthor || $user_id != $article->getAuthorId()) {
            UserException::throw("User tidak dapat melakukan penambahan co-Author", 1006, 403);
        }

        foreach ($request->getCoAuthorIds() as $co_author_id) {
            $co_author = CoAuthor::create(
                new UserId($co_author_id),
                $article_id
            );

            $this->co_author_repository->persist($co_author);
        }
    }
}
