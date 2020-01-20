<?php

namespace App\Console\Commands\Make;

use Illuminate\Console\GeneratorCommand;

class CacheMakeCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create cache class';

    /**
     * @var string
     */
    protected $type = 'Caches';

    /**
     * @return string
     */
    public function getStub()
    {
        $stub = '/stubs/cache.stub';
        return resource_path() . $stub;
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Services\Cache';
    }

    /**
     * @return string
     */
    protected function getNameInput()
    {
        return parent::getNameInput() . 'Cache';
    }
}
