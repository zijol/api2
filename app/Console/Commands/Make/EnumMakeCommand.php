<?php

namespace App\Console\Commands\Make;

use Illuminate\Console\GeneratorCommand;

class EnumMakeCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:enum';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create enum class';

    /**
     * @var string
     */
    protected $type = 'Enums';

    /**
     * @return string
     */
    public function getStub()
    {
        $stub = '/stubs/enums.stub';
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
        return $rootNamespace . '\Enums';
    }

    /**
     * @return string
     */
    protected function getNameInput()
    {
        return parent::getNameInput() . 'Enum';
    }
}
