<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class AddToRoutesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:add-to-routes {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add model to crud routes';

    /**
     * Filesystem instance
     * @var Filesystem
     */
    protected $files;

    /**
     * Create a new command instance.
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $file = $this->getSourceFilePath();
        if ($file) {
            $content = file_get_contents($file);
            return $this->AddCrudRoutes($content);
        }
    }


    /**
     * Get the full path of generate class
     *
     * @return string
     */
    public function getSourceFilePath()
    {
        return base_path('routes/web.php');
    }

    /**
     * Add Crud Routes
     * @param string $content
     *
     * @return string
     */
    public function AddCrudRoutes(string $content)
    {
        if (str_contains($content, '// end')) {
            $model = "\\App\\Models\\" . $this->argument('model');
            $path = $model::FILE_UPLOAD_PATH;

            $transArray[$path] = [
                "title_plural" => Str::studly(Str::plural($path)),
                "title_singular" => Str::studly(Str::singular($path)),
            ];

            // get model fillable
            $modelFillable = (new $model)->getFillable();

            $routes = "\n" . "// " . Str::studly(Str::plural($path)) . "\n"
                . "Route::resource('{$path}', " . Str::studly(Str::singular($path)) . "Controller::class);";


            if (in_array('is_active', $modelFillable)) {
                $routes = $routes . "\n" . "Route::put('/" . $path . "/{id}/toggleActivity', [" . Str::studly(Str::singular($path)) . "Controller::class, 'toggleActivity'])->name('" . $path . ".toggleActivity');";
            }

            $routes = $routes . "\n" . '// end';
            $content = str_replace('// end', $routes, $content);
            file_put_contents($this->getSourceFilePath(), $content);

            return $content;
        }
    }
}
