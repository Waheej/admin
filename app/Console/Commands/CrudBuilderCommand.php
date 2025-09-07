<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class CrudBuilderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud:build {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates Full View Crud for the specified model';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // add Controller
        Artisan::call('make:crud-controller', [
            'model' => $this->argument('model'),
        ]);
        echo ('Model Controller Added' . PHP_EOL);

        // add to Side Menu
        Artisan::call('make:add-to-side-menu', [
            'model' => $this->argument('model'),
        ]);
        echo ('Model Added To Side Menu' . PHP_EOL);

        // add to Translation
        Artisan::call('make:add-to-translation', [
            'model' => $this->argument('model'),
            'locale' => 'en',
        ]);

        Artisan::call('make:add-to-translation', [
            'model' => $this->argument('model'),
            'locale' => 'ar',
        ]);
        echo ('Model Added To Translation' . PHP_EOL);

        // add to Routes
        Artisan::call('make:add-to-routes', [
            'model' => $this->argument('model'),
        ]);
        echo ('Model Added To Routes' . PHP_EOL);

        // add Requests
        Artisan::call('make:crud-request', [
            'model' => $this->argument('model'),
            'type' => 'Create'
        ]);

        Artisan::call('make:crud-request', [
            'model' => $this->argument('model'),
            'type' => 'Update'
        ]);
        echo ('Model Requests Added' . PHP_EOL);


        // add Views
        Artisan::call('make:crud-index-view', [
            'model' => $this->argument('model'),
        ]);

        Artisan::call('make:crud-show-view', [
            'model' => $this->argument('model'),
        ]);

        Artisan::call('make:crud-create-view', [
            'model' => $this->argument('model'),
        ]);

        Artisan::call('make:crud-update-view', [
            'model' => $this->argument('model'),
        ]);
        echo ('Model Views Added' . PHP_EOL);

        // add to Permissions
        Artisan::call('db:seed');
        echo ('Model Added To Permissions' . PHP_EOL);
    }
}
