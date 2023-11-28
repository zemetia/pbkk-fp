<?php

namespace App\Core\Domain\Models\Tag;

use Illuminate\Support\Carbon;
use App\Core\Domain\Models\Article\ArticleId;

class Tag
{
    private int $id;
    private string $tag_name;
    public function __construct(int $id, string $tag_name)
    {
        $this->id = $id;
        $this->tag_name = $tag_name;
    }

    public static function create(int $tag_id, string $tag_name): self
    {
        return new self(
            $tag_id,
            $tag_name
        );
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTagName(): string
    {
        return $this->tag_name;
    }
}
