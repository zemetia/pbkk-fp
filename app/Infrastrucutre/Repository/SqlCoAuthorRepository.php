<?php

namespace App\Infrastrucutre\Repository;

use Exception;
use Illuminate\Support\Facades\DB;
use App\Core\Domain\Models\User\UserId;
use App\Core\Domain\Models\Article\ArticleId;
use App\Core\Domain\Models\CoAuthor\CoAuthor;
use App\Core\Domain\Models\CoAuthor\CoAuthorId;
use App\Core\Domain\Repository\CoAuthorRepositoryInterface;

class SqlCoAuthorRepository implements CoAuthorRepositoryInterface
{
    public function persist(CoAuthor $articles): void
    {
        DB::table('articles')->upsert([
            'id' => $articles->getId()->toString(),
            'article_id' => $articles->getArticleId()->toString(),
            'coauthor_id' => $articles->getCoAuthorId()->toString(),
        ], 'id');
    }

    /**
     * @throws Exception
     */
    public function find(CoAuthorId $id): ?CoAuthor
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
    private function constructFromRow($row): CoAuthor
    {
        return new CoAuthor(
            new CoAuthorId($row->id),
            new UserId($row->coauthor_id),
            new ArticleId($row->article_id)
        );
    }

    public function getByArticleId(ArticleId $article_id): array
    {
        $rows = DB::table('coauthors')->where('article_id', $article_id->toString())->get();

        foreach ($rows as $row) {
            $coauthors[] = $this->constructFromRow($row);
        }

        return $coauthors;
    }

    public function isUserCoAuthoredArticle(UserId $user_id, ArticleId $article_id): bool
    {
        $userHasCoauthoredArticle = DB::table('coauthor')
            ->where('coauthor_id', $user_id)
            ->where('article_id', $article_id)
            ->exists();

        return $userHasCoauthoredArticle;
    }

    public function delete(CoAuthorId $id): void
    {
        DB::table('articles')->where('id', $id->toString())->delete();
    }
}
