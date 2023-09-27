<?php

namespace App\Core\Domain\Models\Article;

enum ArticleVisibility: string
{
    case PUBLISHED = "published";
    case PRIVATE = "private";
    case UNLISTED = "unlisted";
    case DRAF = "draf";
}
