<?php

namespace App\Console\Commands\Make;

use Illuminate\Console\GeneratorCommand;

class RequestMakeCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'zmake:request';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create request class';

    /**
     * @var string
     */
    protected $type = 'Requests';

    /**
     * @var string
     */
    protected $requestType = 'get';

    /**
     * @return string
     */
    public function getStub()
    {
        switch ($this->requestType) {
            case 'get':
                $stub = '/stubs/requests.query.stub';
                break;

            case 'post':
            case 'delete':
            case 'put':
                $stub = '/stubs/requests.modify.stub';
                break;

            case 'list':
                $stub = '/stubs/requests.list.stub';
                break;

            default:
                $stub = '/stubs/requests.query.stub';
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
        switch ($this->requestType) {
            case 'get':
                return $rootNamespace . '\Http\Requests\Query';
            case 'post':
                return $rootNamespace . '\Http\Requests\Modify';
            case 'delete':
                return $rootNamespace . '\Http\Requests\Modify';
            case 'put':
                return $rootNamespace . '\Http\Requests\Modify';
            case 'list':
                return $rootNamespace . '\Http\Requests\QueryList';
            default:
                return $rootNamespace . '\Http\Requests\Query';
        }
    }

    /**
     * @return string
     */
    protected function getNameInput()
    {
        switch ($this->requestType) {
            case 'get':
                return 'Query' . parent::getNameInput() . 'Request';
            case 'post':
                return 'Post' . parent::getNameInput() . 'Request';
            case 'put':
                return 'Put' . parent::getNameInput() . 'Request';
            case 'delete':
                return 'Delete' . parent::getNameInput() . 'Request';
            case 'list':
                return 'List' . parent::getNameInput() . 'Request';
            default:
                return 'Query' . parent::getNameInput() . 'Request';
        }
    }

    public function handle()
    {
        $this->requestType = 'get';
        parent::handle();

        $this->requestType = 'post';
        parent::handle();

        $this->requestType = 'put';
        parent::handle();

        $this->requestType = 'delete';
        parent::handle();

        $this->requestType = 'list';
        parent::handle();
    }
}
