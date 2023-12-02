<?php

namespace Database\Factories;

use App\Core\Domain\Models\User\EloUser;
use Illuminate\Support\Facades\Hash;
use App\Core\Domain\Models\User\User;
use App\Core\Domain\Models\User\UserId;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Core\Domain\Models\User\User>
 */
class UserFactory extends Factory
{
    protected $model = EloUser::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition()
    {
        return [
            'id' => $this->faker->unique()->uuid,
            'roles_id' => $this->faker->numberBetween(1, 2),
            'email' => $this->faker->unique()->safeEmail,
            'name' => $this->faker->name,
            'profile_photo_url' => $this->faker->imageUrl(500, 500),
            'username' => $this->faker->unique()->userName,
            'description' => $this->faker->optional()->text,
            'password' => Hash::make('password'), // Use a default password or generate a secure one
        ];
    }
}
