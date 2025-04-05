<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MemberRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seeders help administer the database
        $role = Role::firstOrCreate(['name' => 'team member']);

        $role->givePermissionTo(Permission::firstOrCreate(['name' => 'view team members']));
    }
}
