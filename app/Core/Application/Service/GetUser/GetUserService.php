<?php

namespace App\Core\Application\Service\GetUser;

use Exception;
use Illuminate\Support\Facades\DB;
use App\Core\Domain\Models\User\User;
use App\Core\Application\Service\PaginationResponse;
use App\Core\Domain\Repository\RoleRepositoryInterface;
use App\Core\Domain\Repository\UserRepositoryInterface;

class GetUserService
{
    private UserRepositoryInterface $user_repository;

    /**
     * @param UserRepositoryInterface $user_repository
     */
    public function __construct(UserRepositoryInterface $user_repository)
    {
        $this->user_repository = $user_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(string $username)
    {
        $user = $this->user_repository->findByUsername($username);
        // $follower
        // $following
        // $authored
        // $co_authored

        return new GetUserResponse($user);
    }
}
