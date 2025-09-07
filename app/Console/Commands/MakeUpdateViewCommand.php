<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class MakeUpdateViewCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:crud-update-view {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make Model update View';

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
        return __DIR__ . '/../../../stubs/admin.update.view.stub';
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
        $model = "\\App\\Models\\" . $this->argument('model');
        $path = $model::FILE_UPLOAD_PATH;

        return [
            'COLUMNS'           => $this->getColumns(),
            'PATH'              => $path,
            'SCRIPT'            => $this->getScript(),
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

        return base_path('resources/views/dashboard/') . $path . '/edit.blade.php';
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
            if (($col == 'updated_at') || ($col == 'deleted_at') || ($col == 'created_at') || ($col == 'is_active')) {
                continue;
            }

            $column =   "<div class=\"form-group\">
                            <label for=\"exampleInput" . Str::studly($col) . "\">{{ trans('cruds.' . \$path . '.' . " . '"' . $col . '"' . ") }}</label>
                            <input type=\"text\" class=\"form-control\" id=\"exampleInput" . Str::studly($col) . "\" name=\"{{ " . '"' . $col . '"'  . " }}\"
                                value=\"{{ old(" . '"' . $col . '"'  . ", \$record->" . $col . ") }}\"
                                placeholder=\"{{ trans('cruds.' . \$path . '.' . " . '"' . $col . '"' . ") }}\">
                            @if (\$errors->has(" . '"' . $col . '"'  . "))
                                <span class=\"text-danger\">{{ \$errors->first(" . '"' . $col . '"'  . ") }}</span>
                            @endif
                        </div>";

            if (str_contains($col, 'description')) {
                $column =   "<div class=\"form-group\">
                                <label for=\"" . $col . "\">
                                    {{ trans('cruds.' . \$path . '.' . '" . $col . "') }}
                                </label>
                                <textarea class=\"form-control\" id=\"" . $col . "\" name=\"" . $col . "\"
                                    placeholder=\"{{ trans('cruds.' . \$path . '.' . '" . $col . "') }}\">
                                    {{ old('" . $col . "', \$record->" . $col . ") }}
                                </textarea>

                                @if (\$errors->has('" . $col . "'))
                                    <span class=\"text-danger\">{{ \$errors->first('" . $col . "') }}</span>
                                @endif
                            </div>";
            }

            $data = $data . "\n" . $column;
        }

        return $data;
    }

    /**
     * Get Script
     * @return string
     */
    public function getScript()
    {
        $model = "\\App\\Models\\" . $this->argument('model');
        $data = '';

        // get model fillable
        $modelFillable = (new $model)->getFillable();

        foreach ($modelFillable as $col) {
            if (str_contains($col, 'description')) {
                $script =   "ClassicEditor
                                .create(document.querySelector('#" . $col . "'))
                                .catch(error => {
                                    console.error('Error initializing CKEditor:', error);
                            });";
                $data = "\n" . $script;
            }
        }

        return $data;
    }
}
