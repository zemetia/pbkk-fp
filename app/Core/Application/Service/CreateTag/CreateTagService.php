<?php

namespace App\Core\Application\Service\CreateTag;

use App\Core\Domain\Models\Article\ArticleId;
use Exception;
use App\Core\Domain\Models\Tag\Tag;
use App\Core\Domain\Models\Role\Role;
use App\Core\Domain\Models\User\UserId;
use App\Core\Domain\Repository\TagRepositoryInterface;
use App\Core\Domain\Repository\RoleRepositoryInterface;

class CreateTagService
{
    private RoleRepositoryInterface $role_repository;
    private TagRepositoryInterface $tag_repository;

    /**
     * @param RoleRepositoryInterface $role_repository
     */

    public function __construct(RoleRepositoryInterface $role_repository, TagRepositoryInterface $tag_repository)
    {
        $this->role_repository = $role_repository;
        $this->tag_repository = $tag_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(CreateTagRequest $request, UserId $user_id)
    {
        $this->tag_repository->persist(
            $request->getTag(),
            new ArticleId($request->getArticleId())
        );
    }
}
