<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class MakeIndexViewCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:crud-index-view {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make Model Index View';

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
        return __DIR__ . '/../../../stubs/admin.index.view.stub';
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
        $columns = $this->getColumns();
        return [
            'COLUMNS_TITLES'             => $columns['titles'],
            'COLUMNS_VALUES'             => $columns['values'],
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

        return base_path('resources/views/dashboard/') . $path . '/index.blade.php';
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

        $data = [
            'titles'     => '',
            'values'     => '',
        ];

        // get model fillable
        $modelFillable = (new $model)->getFillable();

        foreach ($modelFillable as $col) {
            if (($col == 'updated_at') || ($col == 'deleted_at') || ($col == 'created_at')) {
                continue;
            }

            $colTitle = "<th class=\"text-center\">
                            {{ trans('cruds.' . \$path . '.' . " . '"' . $col . '"' . ") }}
                        </th>";


            $data['titles'] = $data['titles'] . "\n" . $colTitle;

            if ($col == 'is_active') {
                $colValue = "@if (canPass(\$path . '_toggleActivity'))
                                <td class=\"text-center\" style=\"padding-top: 1%;\">
                                    <form id=\"{{ 'activeForm-' . \$record->id }}\"
                                        action=\"{{ route('admin.' . \$path . '.toggleActivity', \$record->id) }}\"
                                        method=\"POST\">
                                        @csrf
                                        @method('PUT')
                                    </form>
                                    <label class=\"switch\">
                                        <input onchange=\"submitActiveForm({{ \$record->id }})\" type=\"checkbox\"
                                            {{ \$record->is_active == true ? 'checked' : '' }}>
                                        <span class=\"slider round\"></span>
                                    </label>
                                </td>
                            @endif";
            } else {
                $colValue = "<td class=\"text-center\">
                                {{ \$record->" . $col . "}}
                            </td>";
            }

            $data['values'] = $data['values'] . "\n" . $colValue;
        }

        return $data;
    }
}
