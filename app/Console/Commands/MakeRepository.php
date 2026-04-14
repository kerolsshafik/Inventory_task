<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeRepository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {path}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a repository class at the specified path';

    public function handle()
    {
        // Get the path argument
        $path = $this->argument('path');

        // Generate the full path
        $fullPath = $this->generateFullPath($path);

        // Get the directory where the file will be created
        $directory = dirname($fullPath);

        // Create the directory if it doesn't exist
        $this->makeDirectory($directory);

        // Create the file with the repository class
        $this->makeFile($fullPath, $path);
    }

    /**
     * Generate the full path for the repository class file.
     *
     * @param string $path The relative path to the repository class file
     * @return string The full path to the repository class file
     */
    public function generateFullPath($path)
    {
        // Get the base directory for repositories
        $baseDirectory = app_path('Repositories');
        // Generate the full path by replacing backslashes with forward slashes
        $fullPath = $baseDirectory . '/' . str_replace('\\', '/', $path) . '.php';
        return $fullPath;
    }

    /**
     * Create the directory if it doesn't exist.
     *
     * @param string $directory The directory path
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
     * Create the file with the repository class.
     *
     * @param string $fullPath The full path to the repository class file
     * @param string $path The relative path to the repository class file
     */
    public function makeFile($fullPath, $path)
    {
        // Check if the file already exists
        if (!File::exists($fullPath)) {
            // Get the class name and namespace path
            $className = basename($path);
            $namespacePath = dirname($path);
            $namespace = 'App\\Repositories';

            // Add the namespace path to the namespace
            if ($namespacePath !== '.') {
                $namespace .= '\\' . str_replace('/', '\\', $namespacePath);
            }

            // Create the file with the repository class
            File::put($fullPath, "<?php\n\nnamespace $namespace;\n\nclass $className\n{\n    // Repository methods\n}\n");
            $this->info("Repository created at: $fullPath");
        } else {
            $this->error("Repository already exists at: $fullPath");
        }
    }
}
