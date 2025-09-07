<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class AddToSideMenuCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:add-to-side-menu {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add model to side menu';

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
            return $this->AddSideMenuElement($content);
        }
    }


    /**
     * Get the full path of generate class
     *
     * @return string
     */
    public function getSourceFilePath()
    {
        return base_path('resources/views/layouts/menu.blade.php');
    }

    /**
     * Add SideMenu Element
     * @param string $content
     *
     * @return string
     */
    public function AddSideMenuElement(string $content)
    {
        if (str_contains($content, '{{-- end --}}')) {
            $model = "\\App\\Models\\" . $this->argument('model');
            $path = $model::FILE_UPLOAD_PATH;

            $menuItem =
                "\n" . "@if (canPass('" . $path . "_index'))" . "\n" .
                "\n" . '<li class="nav-item">' . "\n" .
                '    <a href="{{ route(\'admin.' . $path . '.index\') }}" class="{{ str_contains($currentRoute, \'' . $path . '\') ? \'nav-link active\' : \'nav-link\'}}">' . "\n" .
                '        <i class="nav-icon fas fa-tachometer-alt"></i>' . "\n" .
                '        <p>{{ trans(\'cruds.' . $path . '.title_plural\') }}</p>' . "\n" .
                '    </a>' . "\n" .
                '</li>' . "\n" .
                "@endif" . "\n" .
                '{{-- end --}}';
            $content = str_replace('{{-- end --}}', $menuItem, $content);
            file_put_contents($this->getSourceFilePath(), $content);
            return $content;
        }
    }
}
