<?php
namespace App\Services\RedisLock;

class PointsToCashLock extends RedisLock
{
    protected const MILLISECONDS_EXPIRE_TTL = 5000;
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
        return "app:{$this->appId}&user:{$this->userId}&points_to_cash_lock";
    }
}
