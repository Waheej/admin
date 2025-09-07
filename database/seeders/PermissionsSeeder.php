<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $routes = collect(Route::getRoutes()
            ->getRoutesByName())
            ->filter(function ($route) {
                return str_contains($route->getAction()['as'], 'admin.') !== false && str_contains($route->getAction()['as'], 'login') === false;
            })
            ->keys()
            ->toArray();

        foreach ($routes as $route) {
            if (str_contains($route, 'home') || str_contains($route, 'changeLang')) {
                continue;
            }

            $route = str_replace('admin.', '', $route);
            $permission = str_replace('.', '_', $route);
            $group = explode('.', $route);
            Permission::firstOrCreate(
                [
                    'route' => $route,
                ],
                [
                    'route' => $route,
                    'title_en' => Str::title(str_replace('_', ' ', $permission)),
                    'title_ar' => Str::title(str_replace('_', ' ', $permission)),
                    'group' => $group[0],
                    'permission' =>  $permission,
                ]
            );
        }
    }
}
