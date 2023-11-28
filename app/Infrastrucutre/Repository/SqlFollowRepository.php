<?php

namespace App\Infrastrucutre\Repository;

use Exception;
use Illuminate\Support\Facades\DB;
use App\Core\Domain\Models\User\UserId;
use App\Core\Domain\Models\Follow\Follow;
use App\Core\Domain\Models\Follow\FollowId;
use App\Core\Domain\Repository\FollowRepositoryInterface;

class SqlFollowRepository implements FollowRepositoryInterface
{
    public function persist(Follow $articles): void
    {
        DB::table('articles')->upsert([
            'id' => $articles->getId(),
            'from_id' => $articles->getFromId(),
            'to_id' => $articles->getToId(),
        ], 'id');
    }

    /**
     * @throws Exception
     */
    public function find(FollowId $id): ?Follow
    {
        $row = DB::table('follows')->where('id', $id->toString())->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRow($row);
    }

    public function findByUsers(UserId $user, UserId $to): ?Follow
    {
        $row = DB::table('follows')->wheres([
            ['from_id', '=', $user],
            ['to_id', '=', $to]
        ])->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRow($row);
    }

    public function getCountByUserFromId(UserId $user_from_id): int
    {
        return DB::table('follows')->where('from_id', $user_from_id->toString())->count();
    }

    public function getCountByUserToId(UserId $user_to_id): int
    {
        return DB::table('follows')->where('to_id', $user_to_id->toString())->count();
    }

    /**
     * @throws Exception
     */
    private function constructFromRow($row): Follow
    {
        return new Follow(
            new FollowId($row->id),
            new UserId($row->from_id),
            new UserId($row->to_id),
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

    public function getUserFollowWithPagination(UserId $user_id, int $page, int $per_page): array
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

    public function getTaggedFollowWithPagination(string $tag_name, int $page, int $per_page): array
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

    public function delete(FollowId $id): void
    {
        DB::table('follows')->where('id', $id->toString())->delete();
    }
}
