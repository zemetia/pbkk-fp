<?php

namespace App\Core\Application\Service\AddArticle;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Core\Domain\Models\User\UserId;
use App\Core\Domain\Models\Article\Article;
use App\Core\Domain\Models\Article\ArticleVisibility;
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

    function generateUniqueSlug($title, $userId)
    {
        // Create the initial slug from the title
        $baseSlug = Str::of($title)->slug('-');

        // Check if the base slug already exists for the user
        $existingSlugs = DB::table('articles')
            ->where('author_id', $userId->toString())
            ->where('url', 'like', $baseSlug . '%')
            ->pluck('url');

        // If the base slug doesn't exist, use it as is
        if (!$existingSlugs->contains($baseSlug)) {
            return $baseSlug;
        }

        // If it exists, append a unique identifier
        $counter = 1;
        while ($existingSlugs->contains($baseSlug . '-' . $counter)) {
            $counter++;
        }

        return $baseSlug . '-' . $counter;
    }

    /**
     * @throws Exception
     */
    public function execute(AddArticleRequest $request, UserId $user_id)
    {
        $url_slug = $this->generateUniqueSlug($request->getTitle(), $user_id);

        $article = Article::create(
            $user_id,
            ArticleVisibility::from($request->getVisibility()),
            $request->getTitle(),
            $request->getDescription(),
            $request->getContent(),
            $url_slug,
            $request->getImageUrl(),
        );

        $this->article_repository->persist($article);
    }
}
