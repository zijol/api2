<?php

namespace App\Console\Commands\Make;

use Illuminate\Console\GeneratorCommand;

class ModelObjectMakeCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'zmake:model_object';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create objects [simple & item & list] class';

    /**
     * @var string
     */
    protected $type = 'ModelObjects';

    /**
     * @var string
     */
    protected $objectType = 'simple';

    /**
     * @return string
     */
    public function getStub()
    {
        $stub = null;
        switch ($this->objectType) {
            case 'simple':
                $stub = '/stubs/objects.simple.stub';
                break;

            case 'item':
                $stub = '/stubs/objects.item.stub';
                break;

            case 'list':
                $stub = '/stubs/objects.list.stub';
                break;
        }

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
        return $rootNamespace . '\Objects\ModelObjects';
    }

    /**
     * @return string
     */
    protected function getNameInput()
    {
        $sufix = '';
        switch ($this->objectType) {
            case 'simple':
                $sufix = 'Object';
                break;

            case 'item':
                $sufix = 'ItemObject';
                break;

            case 'list':
                $sufix = 'ListObject';
                break;
        }

        return parent::getNameInput() . $sufix;
    }

    /**
     * @return bool|null|void
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        $this->objectType = 'simple';
        parent::handle();

        $this->objectType = 'item';
        parent::handle();

        $this->objectType = 'list';
        parent::handle();
    }
}
