<?php

namespace App\Core\Application\Service\AddCoAuthor;

class AddCoAuthorRequest
{
   private string $article_id;
   private array $co_author_ids;

   /**
    * @param string $name
    */

   public function __construct(string $article_id, array $co_author_ids)
   {
      $this->article_id = $article_id;
      $this->co_author_ids = $co_author_ids;
   }

   public function getArticleId(): string
   {
      return $this->article_id;
   }

   public function getCoAuthorIds(): array
   {
      return $this->co_author_ids;
   }
}
