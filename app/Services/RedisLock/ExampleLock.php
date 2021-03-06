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
    const MILLISECONDS_EXPIRE_TTL = 5000;
    private $appId = '';
    private $userId = '';

    public function __construct($appId, $userId)
    {
        $this->appId = $appId;
        $this->userId = $userId;
        parent::__construct();
    }

    public function getLockKey()
    {
        return "app:{$this->appId}&user:{$this->userId}&finish_task_lock";
    }
}
