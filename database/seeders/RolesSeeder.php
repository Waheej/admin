<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('roles')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Role::firstOrCreate(
            [
                'title_en' => 'Super Admin',
                'title_ar' => 'أدمن',
            ],
            [
                'title_en' => 'Super Admin',
                'title_ar' => 'أدمن',
            ],
        );
    }
}
