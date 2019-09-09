<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 2019/5/19
 * Time: 14:26
 */

namespace App\Services\RedisLock;

class FinishTaskLock extends RedisLock
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
