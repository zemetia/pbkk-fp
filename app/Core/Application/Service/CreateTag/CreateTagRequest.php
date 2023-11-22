<?php

namespace App\Core\Application\Service\CreateTag;

class CreateTagRequest
{
   private string $tag;
   private string $article_id;

   /**
    * @param string $tag
    * @param string $article_id
    */

   public function __construct(string $tag, string $article_id)
   {
      $this->tag = $tag;
      $this->article_id = $article_id;
   }

   public function getTag(): string
   {
      return $this->tag;
   }

   public function getArticleId(): string
   {
      return $this->article_id;
   }
}
