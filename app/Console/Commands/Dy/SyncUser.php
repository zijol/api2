<?php

namespace App\Console\Commands\Dy;

use App\Models\Dy\{
    RawUser, User
};

class SyncUser extends Base
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Dy:SyncUser {port}';
    protected $sleepSecond = 0.1 * 1000000;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '抓取关注用户';

    /**
     * Base constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return bool|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle()
    {
        $args = $this->getArguments();
        $syncTimes = $args['sync_times'] ?? 1;
        $this->port = $args['port'] ?? 5000;

        // 初始化客户端
        $this->initHttpClient($this->port);
        $this->getCookie();

        while (1) {
            $user = User::query()
                ->where('sync_times', '<', $syncTimes)
                ->orderBy('created_at', 'asc')
                ->first();

            $rawUser = $this->getUserInfo($user['id']);

            if (!empty($rawUser)) {
                $rawData = [];
                foreach (static::FIELDS_LIST as $field) {
                    $rawData[$field] = $rawUser[$field] ?? null;
                }
                RawUser::query()->updateOrCreate(['id' => $user['id']], ['raw_data' => $rawData]);
                $user->sync_times = $user->sync_times + 1;
                $user->save();
            }

            usleep($this->sleepSecond / 10);
        }
        return true;
    }
}
