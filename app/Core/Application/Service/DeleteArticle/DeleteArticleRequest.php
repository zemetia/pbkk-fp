<?php

namespace App\Core\Application\Service\DeleteArticle;

class DeleteArticleRequest
{
   private string $username;
   private string $slug;

   /**
    * @param string $article_id
    */

   public function __construct(string $username, string $slug)
   {
      $this->username = $username;
      $this->slug = $slug;
   }

   public function getUsername(): string
   {
      return $this->username;
   }

   public function getSlug(): string
   {
      return $this->slug;
   }
}
