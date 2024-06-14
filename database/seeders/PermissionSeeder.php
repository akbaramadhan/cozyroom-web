<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name'=>'view-owner']);
        Permission::create(['name'=>'view-visitor']);

        Role::create(['name'=>'owner']);
        Role::create(['name'=>'pengunjung']);

        $role_admin = Role::findByName('owner');
        $role_admin->givePermissionTo('view-owner');

        $role_pengguna = Role::findByName('pengunjung');
        $role_pengguna->givePermissionTo('view-visitor');
    }
}
