<?php

namespace App\Console\Commands;

use App\Jobs\ArJob;
use App\Models\Admin\ArObjectModel;
use Illuminate\Console\Command;

class ArSearch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ArSearch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'AR抓取';

    /**
     * Base constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        while (1) {
            $arObjects = ArObjectModel::query()
                ->where('next_time', '<=', date('Y-m-d H:i:s'))
                ->where('status', '!=', 2)
                ->get();

            foreach ($arObjects as $object) {
                ArJob::dispatch([
                    'method' => $object->method,
                    'url' => $object->url,
                    'data' => json_decode($object->data, true),
                    'headers' => json_decode($object->headers, true),
                ])->onConnection('redis');
                $this->line('push');
                $timePeriods = json_decode($object->time_periods, true);

                $object->status = 1;
                $index = array_search($object->next_time, $timePeriods);
                $index = $index ? $index : 0;
                $maxIndex = count($timePeriods) - 1;

                if ($index === $maxIndex) {
                    $object->next_time = $timePeriods[$maxIndex];
                    $object->status = 2;
                } else {
                    $object->next_time = $timePeriods[$index + 1];
                    $object->status = 1;
                }
                $object->save();
            }

            sleep(1);
        }

        return true;
    }
}
