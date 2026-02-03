<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class CreateAdminUserSeeder extends Seeder
{
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {

                $user = User::create([
                        'name' => 'JehadToumah',
                        'email' => 'haetham331@gmail.com',
                        'password' => bcrypt('123123132'),
                        'roles_name' => ["admin"],
                        'Status' => 'مفعل',
                ]);

                $role = Role::where('name', 'admin')->first();

                if ($role) {
                        $user->assignRole($role);
                }
        }
}
