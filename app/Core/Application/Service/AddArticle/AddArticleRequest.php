<?php

namespace App\Core\Application\Service\AddArticle;

class AddArticleRequest
{
   private string $visibility;
   private string $title;
   private string $description;
   private string $content;
   private string $image_url;

   /**
    * @param string $name
    */

   public function __construct(string $visibility, string $title, string $description, string $content, string $image_url)
   {
      $this->visibility = $visibility;
      $this->title = $title;
      $this->description = $description;
      $this->content = $content;
      $this->image_url = $image_url;
   }

   public function getVisibility(): string
   {
      return $this->visibility;
   }

   public function getTitle(): string
   {
      return $this->title;
   }

   public function getDescription(): string
   {
      return $this->description;
   }

   public function getContent(): string
   {
      return $this->content;
   }

   public function getImageUrl(): string
   {
      return $this->image_url;
   }
}
