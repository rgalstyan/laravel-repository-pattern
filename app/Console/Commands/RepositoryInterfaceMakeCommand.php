<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Concerns\CreatesMatchingTest;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'make:repository-interface')]
class RepositoryInterfaceMakeCommand extends GeneratorCommand
{
    use CreatesMatchingTest;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository-interface {name}';

    protected static $defaultName = 'make:repository-interface {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make Repository';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Repository';

    public function handle(): bool|null
    {
        if (parent::handle() === false && !$this->option('force')) {
            return true;
        }

        return false;
    }

    protected function getStub(): string
    {
        return $this->resolveStubPath('/stubs/repo-interface.stub');
    }

    protected function resolveStubPath(string $stub): string
    {

        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
            ? $customPath
            : __DIR__ . $stub;
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        return is_dir(app_path('Repository')) ? $rootNamespace . '\\Repository' : $rootNamespace;
    }
}