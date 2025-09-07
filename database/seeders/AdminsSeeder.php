<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::firstOrCreate(
            [
                'email' => 'super@admin.com',
            ],
            [
                'full_name' => 'Super Admin',
                'email' => 'super@admin.com',
                'country_code' => '+966',
                'mobile' => '057756757',
                'password' => bcrypt(12345678),
                'role_id' => Role::where('title_en','Super Admin')->first()->id,
            ]
        );
    }
}
