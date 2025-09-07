<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class MakeModuleRequestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:crud-request {model} {type}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a Request Class';

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
        return __DIR__ . '/../../../stubs/admin.request.stub';
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
            'MODEL'             => $this->argument('model'),
            'COLUMNS'           => $this->getModelCols($this->argument('model')),
            'TYPE'              => $this->argument('type'),
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
        $path = base_path('app/Http/Requests/Dashboard/') . $this->argument('type') . "/" . $this->argument('type') . $this->argument('model') . 'Request.php';
        return $path;
    }

    /**
     * Build the directory for the class if necessary.
     *
     * @param string $path
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
     * Get Models Cols.
     *
     * @param string $ModelName
     * @param string $module
     * @return string
     */
    protected function getModelCols($ModelName)
    {
        $model = "\\App\\Models\\" . $this->argument('model');
        $instance = new $model;
        $cols = $instance->getFillable();
        $data = [];
        foreach ($cols as $col) {
            if (($col == 'is_active') || ($col == 'updated_at') || ($col == 'created_at') || ($col == 'deleted_at')) {
                continue;
            }
            if (str_contains($col, 'date')) {
                $line = "'" . $col . "' => [\n'required',\n'date',\n'date_format:' . config(\"general.date_format\"),\n],";

                if ($this->argument('type') == 'Update') {
                    $line = "'" . $col . "' => [\n'date',\n'date_format:' . config(\"general.date_format\"),\n],";
                }
                array_push($data, $line);
                continue;
            }
            $line = "'" . $col . "' => [\n'required',\n'string',\n],";
            if ($this->argument('type') == 'Update') {
                $line = "'" . $col . "' => [\n'string',\n],";
            }
            array_push($data, $line);
        }
        return implode("\n", $data);
    }
}
