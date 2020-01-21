<?php

namespace App\Console\Commands\Make;

use Illuminate\Console\GeneratorCommand;

class ControllerMakeCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'zmake:controller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create controller class';

    /**
     * @var string
     */
    protected $type = 'controllers';

    /**
     * @return string
     */
    public function getStub()
    {
        $stub = '/stubs/controller.stub';
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
        return $rootNamespace . '\Http\Controllers\Web';
    }

    /**
     * @return string
     */
    protected function getNameInput()
    {
        return parent::getNameInput() . 'Controller';
    }

    /**
     * @param string $name
     * @return mixed|string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildClass($name)
    {
        $replace = [
            'DummyNameOriginal' => $this->getOriginalName(),
        ];

        return str_replace(
            array_keys($replace), array_values($replace), parent::buildClass($name)
        );
    }

    /**
     * @return string
     */
    protected function getOriginalName()
    {
        return trim($this->argument('name'));
    }
}
