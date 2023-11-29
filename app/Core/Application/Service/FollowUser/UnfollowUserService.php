<?php

namespace App\Core\Application\Service\FollowUser;

use Exception;
use App\Exceptions\UserException;
use App\Core\Domain\Models\User\UserId;
use App\Core\Domain\Models\Article\ArticleId;
use App\Core\Domain\Models\CoAuthor\CoAuthorId;
use App\Core\Domain\Repository\UserRepositoryInterface;
use App\Core\Domain\Repository\FollowRepositoryInterface;
use App\Core\Domain\Repository\ArticleRepositoryInterface;
use App\Core\Domain\Repository\CoAuthorRepositoryInterface;

class UnfollowUserService
{
    private UserRepositoryInterface $user_repository;
    private FollowRepositoryInterface $follow_repository;

    /**
     * @param UserRepositoryInterface $user_repository
     * @param FollowRepositoryInterface $follow_repository
     */

    public function __construct(UserRepositoryInterface $user_repository, FollowRepositoryInterface $follow_repository)
    {
        $this->user_repository = $user_repository;
        $this->follow_repository = $follow_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(string $username, UserId $user_id)
    {
        $user = $this->user_repository->findByUsername($username);
        if (!$user) {
            UserException::throw("User tidak ditemukan", 1006, 404);
        }

        $follow = $this->follow_repository->findByUsers($user_id, $user->getId());
        $this->follow_repository->delete($follow->getId());
    }
}
