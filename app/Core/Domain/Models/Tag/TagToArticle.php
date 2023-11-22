<?php

namespace App\Core\Domain\Models\Tag;


class TagToArticle
{
    private int $id;
    private string $name;
    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public static function create(int $id, string $name): self
    {
        return new self(
            $id,
            $name
        );
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
