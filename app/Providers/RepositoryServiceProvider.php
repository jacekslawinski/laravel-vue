<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use RecursiveIteratorIterator;

class RepositoryServiceProvider extends ServiceProvider
{
    private const REPOSITORY_INTERFACE_DIR = 'Repositories' . DIRECTORY_SEPARATOR . 'Interfaces';
    private const REPOSITORY_NAMESPACE = 'App\Repositories';

    public function boot()
    {
        $this->scanDir(base_path('app' . DIRECTORY_SEPARATOR . self::REPOSITORY_INTERFACE_DIR), '');
    }

    /**
     *
     * @param string $path
     * @param string $nameSpace
     * @return void
     */
    private function scanDir(string $path, string $nameSpace): void
    {
        $directoryIterator = new \RecursiveDirectoryIterator($path, \FilesystemIterator::SKIP_DOTS);
        $fileIterator = new \RecursiveIteratorIterator($directoryIterator, RecursiveIteratorIterator::SELF_FIRST);
        foreach ($fileIterator as $file) {
            $fileName = $file->getBasename('Interface.php');
            if ($file->isFile()) {
                $this->bind($nameSpace . '\\' . $fileName);
            }
            if ($file->isDir()) {
                $this->scanDir($path . DIRECTORY_SEPARATOR . $fileName, $nameSpace . '\\' . $fileName);
            }
        }
    }

    /**
     *
     * @param string $nameSpace
     */
    private function bind(string $nameSpace): void
    {
        $this->app->bind(
            self::REPOSITORY_NAMESPACE . '\Interfaces' . $nameSpace . 'Interface',
            self::REPOSITORY_NAMESPACE . $nameSpace
        );
    }
}
