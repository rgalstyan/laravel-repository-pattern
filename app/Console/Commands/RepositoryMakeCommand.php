<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Concerns\CreatesMatchingTest;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'make:repo')]
class RepositoryMakeCommand extends GeneratorCommand
{
    use CreatesMatchingTest;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repo  {name}';

    protected static $defaultName = 'make:repo {name}';

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
        $this->call('make:repository-interface', ['name' => $this->getNameInput() . 'Interface']);

        if (parent::handle() === false && !$this->option('force')) {
            return false;
        }

        return true;
    }

    protected function getStub(): string
    {
        return $this->resolveStubPath('/stubs/repo.stub');
    }

    protected function resolveStubPath(string $stub): string
    {

        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
            ? $customPath
            : __DIR__ . $stub;
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        Log::info($rootNamespace);
        return is_dir(app_path('Repository')) ? $rootNamespace . '\\Repository\Eloquent' : $rootNamespace;
    }
}