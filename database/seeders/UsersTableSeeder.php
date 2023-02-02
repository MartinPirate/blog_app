<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $this->createAnAdminUser();
        $this->generateUsers();
    }

    /**
     *
     * Seed an Admin User
     * @return void
     */
    private function createAnAdminUser(): void
    {
        $admin = User::create([
            'name' => "admin admin",
            'email' => "admin@app.com",
            'email_verified_at' => now(),
            'password' => bcrypt('P@ssw0rd'),
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'remember_token' => Str::random(10),
            'profile_photo_path' => null,
            'current_team_id' => null,
        ]);


        $adminRole = Role::whereName('admin')->first();
        $admin->attachRole($adminRole);

    }


    /**
     *
     * Generate other 10 users with 10 posts each
     * @return void
     */
    private function generateUsers(): void

    {
        $userRole = Role::whereName('user')->first();
        $users = User::factory(10)
            ->has(Post::factory(10))
            ->create();

        $users->each(function ($user) use ($userRole) {
            $user->attachRole($userRole);
        });

    }
}
