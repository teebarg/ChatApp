<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = ['Super Admin', 'Admin', 'User'];
        $permissions = ['Create User', 'View User', 'Edit User', 'Delete User'];
        $status = ['won','lost','progress', 'void'];
        $market = ['Daily 2 Odds', 'Accumulator', 'Vip'];
        for ($i=0; $i<count($data); $i++){
            Role::create([
                'name' => $data[$i],
                'guard_name' => 'web',
            ]);
        }

        for ($i=0; $i<count($permissions); $i++){
            Permission::create([
                'name' => $permissions[$i],
                'guard_name' => 'web',
            ]);
        }
        for ($i=0; $i<count($status); $i++){
            factory(\App\Status::class)->create(['status' => $status[$i]]);
        }

        for ($i=0; $i<count($market); $i++){
            factory(\App\Market::class)->create(['market' => $market[$i]]);
        }
    }
}
