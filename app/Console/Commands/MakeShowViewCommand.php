<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class MakeShowViewCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:crud-show-view {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make Model show View';

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
        $path = $this->getSourceFilePath();
        $this->makeDirectory(dirname($path));

        $contents = $this->getSourceFile();

        if (!$this->files->exists($path)) {
            $this->files->put($path, $contents);
            $this->info("File : {$path} created");
        } else {
            $this->info("File : {$path} already exits");
        }
    }

    /**
     * Return the stub file path
     * @return string
     *
     */
    public function getStubPath()
    {
        return __DIR__ . '/../../../stubs/admin.show.view.stub';
    }

    /**
     **
     * Map the stub variables present in stub to its value
     *
     * @return array
     *
     */
    public function getStubVariables()
    {
        return [
            'COLUMNS'             => $this->getColumns(),
        ];
    }

    /**
     * Get the stub path and the stub variables
     *
     * @return bool|mixed|string
     *
     */
    public function getSourceFile()
    {
        return $this->getStubContents($this->getStubPath(), $this->getStubVariables());
    }


    /**
     * Replace the stub variables(key) with the desire value
     *
     * @param $stub
     * @param array $stubVariables
     * @return bool|mixed|string
     */
    public function getStubContents($stub, $stubVariables = [])
    {
        $contents = file_get_contents($stub);

        foreach ($stubVariables as $search => $replace) {
            $contents = str_replace('$' . $search . '$', $replace, $contents);
        }

        return $contents;
    }

    /**
     * Get the full path of generate class
     *
     * @return string
     */
    public function getSourceFilePath()
    {
        $model = "\\App\\Models\\" . $this->argument('model');
        $path = $model::FILE_UPLOAD_PATH;

        return base_path('resources/views/dashboard/') . $path . '/show.blade.php';
    }


    /**
     * Build the directory for the class if necessary.
     *
     * @param  string  $path
     * @return string
     */
    protected function makeDirectory($path)
    {
        if (!$this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0777, true, true);
        }

        return $path;
    }

    /**
     * Get Columns
     * @return string
     */
    public function getColumns()
    {
        $model = "\\App\\Models\\" . $this->argument('model');

        $data = '';

        // get model fillable
        $modelFillable = (new $model)->getFillable();

        foreach ($modelFillable as $col) {
            if (($col == 'updated_at') || ($col == 'deleted_at')) {
                continue;
            }

            $column =   "<div class=\"form-group\">
                            <label for=\"exampleInput" . Str::studly($col) . "\">{{ trans('cruds.' . \$path . '.' . " . '"' . $col . '"' . ") }}</label>
                            <input type=\"text\" class=\"form-control\" id=\"exampleInput" . Str::studly($col) . "\" value=\"{{ \$record->" . $col . " ?? '' }}\" disabled>
                        </div>";

            if ($col == 'created_at') {
                $column =   "<div class=\"form-group\">
                                <label for=\"exampleInput" . Str::studly($col) . "\">{{ trans('cruds.' . \$path . '.' . " . '"' . $col . '"' . ") }}</label>
                                <input type=\"text\" class=\"form-control\" id=\"exampleInput" . Str::studly($col) . "\" value=\"{{ \Carbon\Carbon::parse(\$record->" . $col . ")->diffForHumans() ?? '' }}\" disabled>
                            </div>";
            }

            if ($col == 'is_active') {
                $column =   "<label>{{ trans('cruds.' . \$path . '.is_active') }}</label>
                            <div class=\"form-group\">
                                <label class=\"switch\">
                                    <input type=\"checkbox\" class=\"form-control\" id=\"exampleInputIsActive\"
                                        {{ \$record->is_active == true ? 'checked' : '' }} disabled>
                                    <span class=\"slider round\"></span>
                                </label>
                            </div>";
            }

            if (str_contains($col, 'description')) {
                $column =   "<div class=\"form-group\">
                                <label for=\"" . $col . "\">
                                {{ trans('cruds.' . \$path . '.' . '" . $col . "') }}
                                </label>
                                <div class=\"form-control\" id=\"" . $col . "\" style=\"min-height: 150px; overflow-y: auto;\">
                                    {!! \$record->" . $col . " ?? '<em>No description available</em>' !!}
                                </div>

                                @if (\$errors->has('" . $col . "'))
                                    <span class=\"text-danger\">{{ \$errors->first('" . $col . "') }}</span>
                                @endif
                            </div>";
            }

            $data = $data . "\n" . $column;
        }

        return $data;
    }
}
