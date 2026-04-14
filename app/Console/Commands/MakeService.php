<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeService extends Command
{
    protected $signature = 'make:service {path}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a service class at the specified path';

    /**
     * make a service class at the specified path
     */
    /**
     * Handle the console command.
     *
     * @return void
     */
    public function handle()
    {
        // Get the path argument from the command
        $path = $this->argument('path');

        // Generate the full path for the service class
        $fullPath = $this->generateFullPath($path);

        // Generate the directory for the service class
        $directory = dirname($fullPath);
        $this->makeDirectory($directory);

        // Create the service class file
        $this->makeFile($fullPath, $path);
    }

    /**
     * Generate the full path for the service class.
     *
     * @param  string  $path
     * @return string
     */
    public function generateFullPath($path)
    {
        // Get the base directory for Services
        $baseDirectory = app_path('Services');
        // Generate the full path by replacing backslashes with forward slashes
        $fullPath = $baseDirectory . '/' . str_replace('\\', '/', $path) . '.php';
        return $fullPath;
    }

    /**
     * Make the directory for the service class.
     *
     * @param  string  $directory
     * @return void
     */
    public function makeDirectory($directory)
    {
        // Check if the directory already exists
        if (!File::isDirectory($directory)) {
            // Create the directory with read, write, execute permissions for owner and group
            File::makeDirectory($directory, 0777, true);
            $this->info("Directory created at: $directory");
        } else {
            $this->info("Directory already exists at: $directory");
        }
    }

    /**
     * Create the service class file.
     *
     * @param  string  $fullPath
     * @param  string  $path
     * @return void
     */
    public function makeFile($fullPath, $path)
    {
        // Check if the file already exists
        if (!File::exists($fullPath)) {
            // Get the class name and namespace path
            $className = basename($path);
            $namespacePath = dirname($path);
            $namespace = 'App\\Services';
            // Add the namespace path to the namespace
            if ($namespacePath !== '.') {
                $namespace .= '\\' . str_replace('/', '\\', $namespacePath);
            }
            // Create the file with the repository class
            File::put($fullPath, "<?php\n\nnamespace $namespace;\n\nclass $className\n{\n    // Service methods\n}\n");
            $this->info("Service created at: $fullPath");
        } else {
            $this->error("Service already exists at: $fullPath");
        }
    }
}
