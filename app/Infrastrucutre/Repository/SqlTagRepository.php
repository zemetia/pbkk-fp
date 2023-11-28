<?php

namespace App\Infrastrucutre\Repository;

use Exception;
use Illuminate\Support\Facades\DB;
use App\Core\Domain\Models\User\UserId;
use App\Core\Domain\Models\Tag\Tag;
use App\Core\Domain\Models\Tag\TagId;
use App\Core\Domain\Models\Tag\TagVisibility;
use App\Core\Domain\Repository\TagRepositoryInterface;

class SqlTagRepository implements TagRepositoryInterface
{
    public function persist(Tag $articles): void
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
    public function find(TagId $id): ?Tag
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
    private function constructFromRow($row): Tag
    {
        return new Tag(
            new TagId($row->id),
            new UserId($row->author_id),
            TagVisibility::from($row->visibility),
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

    public function getUserTagWithPagination(UserId $user_id, int $page, int $per_page): array
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

    public function getTaggedTagWithPagination(string $tag_name, int $page, int $per_page): array
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

    public function delete(TagId $id): void
    {
        DB::table('articles')->where('id', $id->toString())->delete();
    }
}
