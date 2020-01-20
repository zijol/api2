<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class ObjectMakeCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:object';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create objects [simple] class';

    /**
     * @var string
     */
    protected $type = 'Objects';

    /**
     * @return string
     */
    public function getStub()
    {
        $stub = '/stubs/objects.simple.stub';
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
        return $rootNamespace . '\Objects';
    }

    /**
     * @return string
     */
    protected function getNameInput()
    {
        return parent::getNameInput() . 'Object';
    }
}
