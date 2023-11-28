<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\User\UserId;
use App\Core\Domain\Models\Follow\Follow;
use App\Core\Domain\Models\Follow\FollowId;

interface FollowRepositoryInterface
{
    /**
     * @param string $id
     * @return Follow[]
     */
    public function persist(Follow $follow): void;

    public function delete(FollowId $follow): void;

    public function getCountByUserFromId(UserId $user_from_id): int; // FROM(user) Following TO(user) || berarti ini dapetin dia following siapa aja

    public function getCountByUserToId(UserId $user_to_id): int; // FROM(user) Following TO(user) || berarti ini dapetin dia difollow siapa aja

    // public function isUserFollowedTo(UserId $user_from_id, UserId $user_to_id): bool;

    public function findByUsers(UserId $user, UserId $to): ?Follow;
}
