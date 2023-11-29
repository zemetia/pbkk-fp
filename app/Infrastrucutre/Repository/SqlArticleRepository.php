<?php

namespace App\Infrastrucutre\Repository;

use Exception;
use Illuminate\Support\Facades\DB;
use App\Core\Domain\Models\User\UserId;
use App\Core\Domain\Models\Article\Article;
use App\Core\Domain\Models\Article\ArticleId;
use App\Core\Domain\Models\Article\ArticleVisibility;
use App\Core\Domain\Repository\ArticleRepositoryInterface;

class SqlArticleRepository implements ArticleRepositoryInterface
{
    public function persist(Article $articles): void
    {
        DB::table('articles')->upsert([
            'id' => $articles->getId()->toString(),
            'url' => $articles->getUrl(),
            'title' => $articles->getTitle(),
            'content' => $articles->getContent(),
            'image_url' => $articles->getImageUrl(),
            'author_id' => $articles->getAuthorId()->toString(),
            'visibility' => $articles->getVisibility()->value,
            'description' => $articles->getDescription(),
        ], 'id');
    }

    /**
     * @throws Exception
     */
    public function find(ArticleId $id): ?Article
    {
        $row = DB::table('articles')->where('id', $id->toString())->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRow($row);
    }

    public function findByUsernameAndSlug(string $username, string $slug): ?Article
    {
        $author = DB::table('users')->where('username', $username)->first();
        if (!$author) {
            return null;
        }



        $row = DB::table('articles')->where('id', $author->id)->where('url', $slug)->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRow($row);
    }

    /**
     * @throws Exception
     */
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

    public function getWithPagination(int $page, int $per_page): array
    {
        $rows = DB::table('articles')
            ->paginate($per_page, ['*'], 'role_page', $page);
        $articles = [];

        foreach ($rows as $row) {
            $articles[] = $this->constructFromRow($row);
        }
        return [
            "data" => $articles,
            "max_page" => ceil($rows->total() / $per_page)
        ];
    }

    public function getUserArticleWithPagination(UserId $user_id, int $page, int $per_page): array
    {
        $rows = DB::table('articles')->where('author_id', "=", $user_id->toString())
            ->paginate($per_page, ['*'], 'role_page', $page);
        $articles = [];

        foreach ($rows as $row) {
            $articles[] = $this->constructFromRow($row);
        }
        return [
            "data" => $articles,
            "max_page" => ceil($rows->total() / $per_page)
        ];
    }

    public function getTaggedArticleWithPagination(string $tag_name, int $page, int $per_page): array
    {
        $rows = DB::table('articles')->join('tags', 'articles.id', "=", "tags.article_id")->where('tags.tag_name', '=', $tag_name)
            ->paginate($per_page, ['*'], 'role_page', $page);
        $articles = [];

        foreach ($rows as $row) {
            $articles[] = $this->constructFromRow($row);
        }
        return [
            "data" => $articles,
            "max_page" => ceil($rows->total() / $per_page)
        ];
    }

    public function delete(ArticleId $id): void
    {
        DB::table('articles')->where('id', $id->toString())->delete();
    }
}
