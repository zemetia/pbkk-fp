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
            'id' => $articles->getId(),
            'url' => $articles->getUrl(),
            'title' => $articles->getTitle(),
            'content' => $articles->getContent(),
            'image_url' => $articles->getImageUrl(),
            'author_id' => $articles->getAuthorId(),
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

    /**
     * @throws Exception
     */
    public function findLargestId(): ?int
    {
        $row = DB::table('articles')->max('id');

        if (!$row) {
            return null;
        }

        return $row;
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

    public function delete(ArticleId $id): void
    {
        DB::table('articles')->where('id', $id->toString())->delete();
    }
}
