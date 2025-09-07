<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = Permission::pluck('id')->all();
        $user = Admin::whereEmail('super@admin.com')->first();
        
        Admin::findOrFail($user->id)->permissions()->sync($permissions);
        

    }
}
