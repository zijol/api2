<?php
/**
 * Created by PhpStorm.
 * User: zjiol
 * Date: 2019-05-28
 * Time: 23:05
 */

namespace App\Services\Cache;

class ExampleCache extends BaseCache
{
    const CACHE_NAME = 'example';

    protected $_relies = [
        'name' => 'name'
    ];
}