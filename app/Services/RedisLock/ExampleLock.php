<?php
/**
 * Created by PhpStorm.
 * User: zjiol
 * Date: 2019-05-29
 * Time: 22:11
 */

namespace App\Services\RedisLock;

class ExampleLock extends RedisLock
{
    protected const LOCK_KEY = 'example_lock';
    protected const MILLISECONDS_EXPIRE_TTL = 5000;
}