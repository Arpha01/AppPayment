<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();

        $user->name = 'User 001';
        $user->email = 'user@test.com';
        $user->is_organization = false;
        $user->password = bcrypt('test123');

        $user->save();

        //Organization user (admin)

        $organization = Organization::create([
            'name' => 'Kemendikbud RI',
            'slug' => 'kemendikbud-ri',
        ]);

        $user = new User();

        $user->name = 'Kemendikbud RI';
        $user->email = 'kemendikbud@test.com';
        $user->is_organization = true;
        $user->organization_id = $organization->id;
        $user->password = bcrypt('test123');

        $user->save();
    }
}
