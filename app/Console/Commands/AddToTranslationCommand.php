<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class AddToTranslationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:add-to-translation {model} {locale}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add model to crud translation';

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
            return $this->AddCrudTranslation($content);
        }
    }


    /**
     * Get the full path of generate class
     *
     * @return string
     */
    public function getSourceFilePath()
    {
        return base_path('lang/' . $this->argument('locale') . '/cruds.php');
    }

    /**
     * Add Crud Translation
     * @param string $content
     *
     * @return string
     */
    public function AddCrudTranslation(string $content)
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

            foreach ($modelFillable as $col) {
                $transArray[$path][$col] = Str::studly($col);
            }

            // Parse the existing content to an array
            $existingArray = eval('?>' . $content);

            // Merge the new translations with the existing array
            $mergedArray = array_merge($existingArray, $transArray);

            // Convert the merged array back to a string representation
            $crudTranslation = var_export($mergedArray, true);

            // Ensure proper formatting for the return statement
            $content = "<?php\n\nreturn " . $crudTranslation . ";\n" . '// end';

            file_put_contents($this->getSourceFilePath(), $content);

            return $content;
        }
    }
}
