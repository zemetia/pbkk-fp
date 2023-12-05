<?php

namespace App\Core\Application\Service\GetArticleList;

use Exception;
use Illuminate\Support\Facades\DB;
use App\Core\Domain\Models\User\User;
use App\Core\Domain\Models\User\UserId;
use App\Core\Domain\Models\Article\Article;
use App\Core\Domain\Models\Article\ArticleId;
use App\Core\Application\Service\PaginationResponse;
use App\Core\Domain\Models\Article\ArticleVisibility;
use App\Core\Domain\Repository\RoleRepositoryInterface;
use App\Core\Domain\Repository\UserRepositoryInterface;
use App\Core\Domain\Repository\ArticleRepositoryInterface;
use App\Core\Domain\Repository\CoAuthorRepositoryInterface;
use App\Core\Application\Service\GetArticleList\GetArticleListRequest;
use App\Core\Application\Service\GetArticleList\GetArticleListResponse;

class GetArticleListService
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

    private function constructFromRow($row): Article
    {
        return new Article(
            new ArticleId($row->id),
            new UserId($row->author_id),
            ArticleVisibility::from($row->visibility),
            $row->title,
            $row->description,
            $row->content,
            $row->url,
            $row->image_url,
            $row->created_at,
            $row->updated_at,
        );
    }

    public function unpackAuthors(User $user): array
    {
        return array(
            "name" => $user->getName(),
            "username" => $user->getUsername(),
            "photo" => $user->getProfilePhotoUrl(),
            "description" => $user->getDescription()
        );
    }

    /**
     * @throws Exception
     */
    public function execute(GetArticleListRequest $request)
    {
        $rows = DB::table('articles as a')
            ->leftJoin('tag_to_articles as tta', 'a.id', '=', 'tta.article_id')
            ->leftJoin('tags as t', 'tta.tag_id', '=', 't.id');

        if ($request->getTags())
            $rows = $rows->whereIn('t.name', $request->getTags());

        if ($request->getSearch()) {
            $words = explode(' ', $request->getSearch());
            // $rows->where('articles.name', 'like', '%' . $request->getSearch() . '%');
            foreach ($words as $word) {
                $rows = $rows->where(function ($query) use ($word) {
                    $query->where(DB::raw('LOWER(a.title)'), 'like', '%' . strtolower($word) . '%')
                        ->orWhere(DB::raw('LOWER(a.content)'), 'like', '%' . strtolower($word) . '%');
                });
            }
        }

        if ($request->getSort())
            $rows = $rows->orderBy($request->getSort(), $request->getType());

        // $rows->distinct('a.*');
        $rows->select('a.*')->distinct();
        $rows = $rows->paginate($request->getPerPage(), ['a.*'], 'article_page', $request->getPage());

        $articles = [];
        foreach ($rows as $row) {
            $articles[] = $this->constructFromRow($row);
        }

        $articles_pagination = [
            "data" => $articles,
            "max_page" => ceil($rows->total() / $request->getPerPage())
        ];

        $max_page = $articles_pagination['max_page'];

        $user_response = array_map(function (Article $article) {
            $author = $this->user_repository->find($article->getAuthorId());
            $coauthors = $this->co_author_repository->getByArticleId($article->getId());

            $coauthors_unpack = array_map(function (User $user) {
                return $this->unpackAuthors($user);
            }, $coauthors);

            return new GetArticleListResponse(
                $article,
                $this->unpackAuthors($author),
                $coauthors_unpack
            );
        }, $articles_pagination['data']);

        return new PaginationResponse($user_response, $request->getPage(), $max_page);
    }
}
