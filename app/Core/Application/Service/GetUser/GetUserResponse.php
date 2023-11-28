<?php

namespace App\Core\Application\Service\GetUser;

use JsonSerializable;
use App\Core\Domain\Models\User\User;

class GetUserResponse implements JsonSerializable
{
    private User $user;
    private int $follower;
    private int $following;
    private int $authored;
    private int $co_authored;
    private array $articles;

    /**
     * @param User $user
     * @param int $follower
     * @param int $following
     * @param int $authored
     * @param int $co_authored
     * @param array $articles
     */
    public function __construct(User $user, int $follower, int $following, int $authored, int $co_authored, array $articles)
    {
        $this->user = $user;
        $this->follower = $follower;
        $this->following = $following;
        $this->authored = $authored;
        $this->co_authored = $co_authored;
        $this->articles = $articles;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->user->getId()->toString(),
            'name' => $this->user->getName(),
            'email' => $this->user->getEmail()->toString(),
            'username' => $this->user->getUsername(),
            'photo_profile_url' => $this->user->getProfilePhotoUrl(),
            'description' => $this->user->getDescription(),
            'count' => [
                'follower' => $this->follower,
                'following' => $this->following,
                'authored' => $this->authored,
                'co_authored' => $this->co_authored
            ],
            'articles' => $this->articles,
        ];
    }
}
