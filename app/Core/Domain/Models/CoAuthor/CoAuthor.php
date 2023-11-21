<?php

namespace App\Core\Domain\Models\CoAuthor;

use Illuminate\Support\Carbon;
use App\Core\Domain\Models\User\UserId;
use App\Core\Domain\Models\Article\ArticleId;
use App\Core\Domain\Models\CoAuthor\CoAuthorId;

class CoAuthor
{
    private CoAuthorId $id;
    private UserId $coauthor_id;
    private ArticleId $article_id;
    public function __construct(CoAuthorId $id, UserId $coauthor_id, ArticleId $article_id)
    {
        $this->id = $id;
        $this->coauthor_id = $coauthor_id;
        $this->article_id = $article_id;
    }

    public static function create(UserId $coauthor_id, ArticleId $article_id): self
    {
        return new self(
            CoAuthorId::generate(),
            $coauthor_id,
            $article_id,
        );
    }

    public function getId(): CoAuthorId
    {
        return $this->id;
    }

    public function getArticleId(): ArticleId
    {
        return $this->article_id;
    }

    public function getCoAuthorId(): UserId
    {
        return $this->coauthor_id;
    }
}
