<?php

namespace App\Infrastrucutre\Repository;

use Exception;
use Illuminate\Support\Facades\DB;
use App\Core\Domain\Models\Tag\Tag;
use App\Core\Domain\Models\Tag\TagId;
use App\Core\Domain\Models\User\UserId;
use App\Core\Domain\Models\Tag\TagToArticle;
use App\Core\Domain\Models\Article\ArticleId;
use App\Core\Domain\Models\Tag\TagToArticleId;
use App\Core\Domain\Models\Tag\TagVisibility;
use App\Core\Domain\Repository\TagRepositoryInterface;

class SqlTagRepository implements TagRepositoryInterface
{
    public function persist(string $tag, ArticleId $articleId): void
    {
        $existingTag = DB::table('tags')->where('name', $tag)->first();

        if (!$existingTag) {
            DB::table('tags')->updateOrInsert(
                ['name' => $tag],
            );
        }

        $existingTag = DB::table('tags')->where('name', $tag)->first();

        $tag_to_article = TagToArticle::create($articleId, $existingTag->id);

        DB::table('tag_to_articles')->upsert([
            'id' => $tag_to_article->getId(),
            'article_id' => $tag_to_article->getArticleId(),
            'tag_id' => $tag_to_article->getTagId(),
        ], 'id');
    }

    /**
     * @throws Exception
     */
    public function find(int $id): ?Tag
    {
        $row = DB::table('articles')->where('id', $id)->first();

        if (!$row) {
            return null;
        }

        return $this->constructTagFromRow($row);
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
    private function constructTagFromRow($row): Tag
    {
        return new Tag(
            $row->id,
            $row->name,
        );
    }

    private function constructTagToArticleFromRow($row): TagToArticle
    {
        return new TagToArticle(
            new TagToArticleId($row->id),
            new ArticleId($row->article_id),
            $row->tag_id
        );
    }

    // public function getWithPagination(int $page, int $per_page): array
    // {
    //     $rows = DB::table('articles')
    //         ->paginate($per_page, ['*'], 'role_page', $page);
    //     $articles = [];

    //     foreach ($rows as $row) {
    //         $articles[] = $this->constructFromRow($row);
    //     }
    //     return [
    //         "data" => $articles,
    //         "max_page" => ceil($rows->total() / $per_page)
    //     ];
    // }

    // public function getUserTagWithPagination(UserId $user_id, int $page, int $per_page): array
    // {
    //     $rows = DB::table('articles')->where('author_id', "=", $user_id->toString())
    //         ->paginate($per_page, ['*'], 'role_page', $page);
    //     $articles = [];

    //     foreach ($rows as $row) {
    //         $articles[] = $this->constructFromRow($row);
    //     }
    //     return [
    //         "data" => $articles,
    //         "max_page" => ceil($rows->total() / $per_page)
    //     ];
    // }

    // public function getTaggedTagWithPagination(string $tag_name, int $page, int $per_page): array
    // {
    //     $rows = DB::table('articles')->join('tags', 'articles.id', "=", "tags.article_id")->where('tags.tag_name', '=', $tag_name)
    //         ->paginate($per_page, ['*'], 'role_page', $page);
    //     $articles = [];

    //     foreach ($rows as $row) {
    //         $articles[] = $this->constructFromRow($row);
    //     }
    //     return [
    //         "data" => $articles,
    //         "max_page" => ceil($rows->total() / $per_page)
    //     ];
    // }

    public function getByArticleId(ArticleId $articleId): array
    {
        $rows = DB::table('tags')
            ->join('tag_to_articles', 'tag_to_articles.tag_id', "=", "tags.id")
            ->where('tag_to_articles.article_id', "=", $articleId->toString())
            ->get();

        foreach ($rows as $row) {
            $tags[] = $this->constructTagFromRow($row);
        }

        return $tags;
    }

    public function getAllUniqueTags(): array
    {
        $rows = DB::table('tags')->get();
        $tags = [];

        foreach ($rows as $row) {
            $tags[] = $this->constructTagFromRow($row);
        }

        return $tags;
    }

    public function deleteTag(int $id): void
    {
        DB::table('tags')->where('id', $id)->delete();
    }

    public function deleteTagToArticle(TagToArticleId $id): void
    {
        DB::table('tag_to_articles')->where('id', $id->toString())->delete();
    }
}
