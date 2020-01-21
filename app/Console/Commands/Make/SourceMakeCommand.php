<?php

namespace App\Console\Commands\Make;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\Schema;

class SourceMakeCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'zmake:source';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create source [controller, model, object, request] class';

    /**
     * @var string
     */
    protected $type = 'source';

    /**
     * @var string
     */
    protected $sourceType = 'model';

    /**
     * @var array
     */
    protected $sourceTypes = [
        'model',
        'object_item',
        'object_simple',
        'object_list',
        'request_get',
        'request_post',
        'request_put',
        'request_delete',
        'request_list',
        'controller'
    ];

    /**
     * @return string
     */
    public function getStub()
    {
        $stub = '/stubs/controller.stub';

        switch ($this->sourceType) {
            case 'model':
                $stub = '/stubs/model.stub';
                break;
            case 'object_item':
                $stub = '/stubs/objects.item.stub';
                break;
            case 'object_simple':
                $stub = '/stubs/objects.simple.stub';
                break;
            case 'object_list':
                $stub = '/stubs/objects.list.stub';
                break;
            case 'request_get':
                $stub = '/stubs/requests.query.stub';
                break;
            case 'request_post':
                $stub = '/stubs/requests.modify.stub';
                break;
            case 'request_put':
                $stub = '/stubs/requests.modify.stub';
                break;
            case 'request_delete':
                $stub = '/stubs/requests.modify.stub';
                break;
            case 'request_list':
                $stub = '/stubs/requests.list.stub';
                break;
            case 'controller':
                $stub = '/stubs/controller.stub';
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
        switch ($this->sourceType) {
            case 'model':
                return $rootNamespace . '\Models\Admin';
            case 'object_item':
                return $rootNamespace . '\Objects\ModelObjects';
            case 'object_simple':
                return $rootNamespace . '\Objects\ModelObjects';
            case 'object_list':
                return $rootNamespace . '\Objects\ModelObjects';
            case 'request_get':
                return $rootNamespace . '\Http\Requests\Query';
            case 'request_post':
                return $rootNamespace . '\Http\Requests\Modify';
            case 'request_put':
                return $rootNamespace . '\Http\Requests\Modify';
            case 'request_delete':
                return $rootNamespace . '\Http\Requests\Modify';
            case 'request_list':
                return $rootNamespace . '\Http\Requests\QueryList';
            case 'controller':
                return $rootNamespace . '\Http\Controllers\Web';
        }
    }

    /**
     * @return string
     */
    protected function getNameInput()
    {
        switch ($this->sourceType) {
            case 'model':
                return parent::getNameInput() . 'Model';
            case 'object_item':
                return parent::getNameInput() . 'ItemObject';
            case 'object_simple':
                return parent::getNameInput() . 'Object';
            case 'object_list':
                return parent::getNameInput() . 'ListObject';
            case 'request_get':
                return 'Query' . parent::getNameInput() . 'Request';
            case 'request_post':
                return 'Post' . parent::getNameInput() . 'Request';
            case 'request_put':
                return 'Put' . parent::getNameInput() . 'Request';
            case 'request_delete':
                return 'Delete' . parent::getNameInput() . 'Request';
            case 'request_list':
                return 'List' . parent::getNameInput() . 'Request';
            case 'controller':
                return parent::getNameInput() . 'Controller';
        }
    }

    /**
     * @return bool|null|void
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        foreach ($this->sourceTypes as $sourceType) {
            $this->sourceType = $sourceType;
            parent::handle();
        }
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

        if ($this->sourceType == 'model') {
            $replace['DummyTableName'] = $this->getTableName();
            $replace['DummyModelFillAble'] = $this->getFillAble();
            $replace['DummyModelKeyMap'] = $this->getKeyMap();
        }

        if ($this->sourceType == 'object_item' || $this->sourceType == 'object_simple') {
            $replace['DummyObjectKeys'] = $this->getObjectKeys();
        }

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

    /**
     * @return string
     */
    protected function getTableName()
    {
        return uncamelize(trim($this->argument('name')));
    }

    /**
     * @return string
     */
    protected function getFillAble()
    {
        $tableName = $this->getTableName();
        $columns = Schema::connection('admin')->getColumnListing($tableName);
        $fillAbleStr = "";
        foreach ($columns as $column) {
            $fillAbleStr .= "'$column'," . PHP_EOL . "\t\t";
        }
        return trim($fillAbleStr);
    }

    /**
     * @return string
     */
    protected function getKeyMap()
    {
        $tableName = $this->getTableName();
        $columns = Schema::connection('admin')->getColumnListing($tableName);
        $keyMapStr = "";
        foreach ($columns as $column) {
            $keyMapStr .= "'$column' => '$column'," . PHP_EOL . "\t\t";
        }
        return trim($keyMapStr);
    }

    /**
     * @return string
     */
    protected function getObjectKeys()
    {
        $tableName = $this->getTableName();
        $columns = Schema::connection('admin')->getColumnListing($tableName);
        $objectKeyStr = "";
        foreach ($columns as $column) {
            $objectKeyStr .= "'$column' => [DataTypeEnum::STRING, ]," . PHP_EOL . "\t\t";
        }
        return trim($objectKeyStr);
    }
}
