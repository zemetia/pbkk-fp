<?php

namespace App\Core\Domain\Models\User;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EloUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'roles_id',
        'email',
        'name',
        'profile_photo_url',
        'username',
        'description',
        'password',
    ];

    protected $table = "users";

    protected static function newFactory(): Factory
    {
        return UserFactory::new();
    }
}
