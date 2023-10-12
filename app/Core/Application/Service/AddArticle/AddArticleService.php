<?php

namespace App\Core\Application\Service\AddArticle;

use Exception;
use Illuminate\Support\Str;
use App\Core\Domain\Models\Article\Article;
use App\Core\Domain\Models\Article\ArticleVisibility;
use App\Core\Domain\Models\User\UserId;
use App\Core\Domain\Repository\ArticleRepositoryInterface;

class AddArticleService
{
    private ArticleRepositoryInterface $article_repository;

    /**
     * @param ArticleRepositoryInterface $article_repository
     */

    public function __construct(ArticleRepositoryInterface $article_repository)
    {
        $this->article_repository = $article_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(AddArticleRequest $request, UserId $user_id)
    {
        $url_slug = Str::of($request->getTitle())->slug('-');

        $article = Article::create(
            $user_id,
            ArticleVisibility::from($request->getVisibility()),
            $request->getTitle(),
            $request->getDescription(),
            $request->getContent(),
            $url_slug,
            $request->getImageUrl(),
            $request->getTags()
        );

        $this->article_repository->persist($article);
    }
}
