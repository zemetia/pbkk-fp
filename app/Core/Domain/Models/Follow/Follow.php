<?php

namespace App\Core\Domain\Models\Follow;

use Illuminate\Support\Carbon;
use App\Core\Domain\Models\User\UserId;

class Follow
{
    private FollowId $id;
    private UserId $from_id;
    private UserId $to_id;
    private string $tag_name;
    public function __construct(FollowId $id, UserId $from_id, UserId $to_id)
    {
        $this->id = $id;
        $this->from_id = $from_id;
        $this->to_id = $to_id;
    }

    public static function create(UserId $from_id, UserId $to_id): self
    {
        return new self(
            FollowId::generate(),
            $from_id,
            $to_id
        );
    }

    public function getId(): FollowId
    {
        return $this->id;
    }

    public function getFromId(): UserId
    {
        return $this->from_id;
    }

    public function getToId(): UserId
    {
        return $this->to_id;
    }
}
