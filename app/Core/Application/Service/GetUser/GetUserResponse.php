<?php

namespace App\Core\Application\Service\GetUser;

use JsonSerializable;
use App\Core\Domain\Models\User\User;

class GetUserResponse implements JsonSerializable
{
    private User $user;

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->user->getId()->toString(),
            'name' => $this->user->getName(),
            'email' => $this->user->getEmail()->toString()
        ];
    }
}
