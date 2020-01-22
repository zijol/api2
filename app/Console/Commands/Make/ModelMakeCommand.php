<?php

namespace App\Console\Commands\Make;

use Illuminate\Console\GeneratorCommand;

class ModelMakeCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'zmake:model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create model class';

    /**
     * @var string
     */
    protected $type = 'Models';

    /**
     * @return string
     */
    public function getStub()
    {
        $stub = '/stubs/model.stub';
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
        return $rootNamespace . '\Models\Admin';
    }

    /**
     * @return string
     */
    protected function getNameInput()
    {
        return parent::getNameInput() . 'Model';
    }
}
