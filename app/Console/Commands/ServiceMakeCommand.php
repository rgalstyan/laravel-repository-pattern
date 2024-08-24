<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Concerns\CreatesMatchingTest;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputOption;

#[AsCommand(name: 'make:service')]
class ServiceMakeCommand extends GeneratorCommand
{
    use CreatesMatchingTest;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service  {name}';

    protected static $defaultName = 'make:service {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make Service';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Service';

    /**
     * Execute the console command.
     *
     * @throws FileNotFoundException
     */
    public function handle(): bool|int
    {
        if (parent::handle() === false && ! $this->option('force')) {
            return false;
        }
        return 0;
    }


    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {

        return $this->resolveStubPath('/stubs/service.stub');
    }

    /**
     * Resolve the fully-qualified path to the stub.
     *
     * @param  string  $stub
     * @return string
     */
    protected function resolveStubPath($stub): string
    {

        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
            ? $customPath
            : __DIR__.$stub;
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return is_dir(app_path('Services')) ? $rootNamespace.'\\Services' : $rootNamespace;
    }

}