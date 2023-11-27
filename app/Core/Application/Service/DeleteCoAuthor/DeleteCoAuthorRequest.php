<?php

namespace App\Core\Application\Service\DeleteCoAuthor;

class DeleteCoAuthorRequest
{
   private string $article_id;
   private string $co_author_id;

   /**
    * @param string $name
    */

   public function __construct(string $article_id, string $co_author_id)
   {
      $this->article_id = $article_id;
      $this->co_author_id = $co_author_id;
   }

   public function getArticleId(): string
   {
      return $this->article_id;
   }

   public function getCoAuthorId(): string
   {
      return $this->co_author_id;
   }
}
