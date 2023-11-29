<?php

namespace Database\Seeders;

use App\Core\Domain\Models\User\EloUser;
use Illuminate\Database\Seeder;

class UserFactorySeeder extends Seeder
{
    public function run()
    {
        EloUser::factory()->count(10)->create();
    }
}
