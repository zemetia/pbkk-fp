<?php

namespace App\Core\Application\Service\GetUser;

use Exception;
use App\Exceptions\UserException;
use Illuminate\Support\Facades\DB;
use App\Core\Domain\Models\User\User;
use App\Core\Application\Service\PaginationResponse;
use App\Core\Domain\Repository\RoleRepositoryInterface;
use App\Core\Domain\Repository\UserRepositoryInterface;
use App\Core\Domain\Repository\FollowRepositoryInterface;
use App\Core\Domain\Repository\ArticleRepositoryInterface;

class GetUserService
{
    private UserRepositoryInterface $user_repository;
    private FollowRepositoryInterface $follow_repository;
    private ArticleRepositoryInterface $article_repository;

    /**
     * @param UserRepositoryInterface $user_repository
     * @param FollowRepositoryInterface $follow_repository
     */
    public function __construct(UserRepositoryInterface $user_repository, FollowRepositoryInterface $follow_repository, ArticleRepositoryInterface $article_repository)
    {
        $this->user_repository = $user_repository;
        $this->follow_repository = $follow_repository;
        $this->article_repository = $article_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(string $username)
    {
        $user = $this->user_repository->findByUsername($username);
        if (!$user) {
            UserException::throw('User tidak ditemukan!', 1004, 404);
        }

        $follower = $this->follow_repository->getCountByUserToId($user->getId());
        $following = $this->follow_repository->getCountByUserFromId($user->getId());
        $authored = DB::table('articles')->where('author_id', '=', $user->getId()->toString())->count();
        $co_authored = DB::table('coauthors')->where('coauthor_id', '=', $user->getId()->toString())->count();

        $articles = $this->article_repository->getUserArticleWithPagination($user->getId(), 1, 10);

        return new GetUserResponse(
            $user,
            $follower,
            $following,
            $authored,
            $co_authored,
            $articles
        );
    }
}
