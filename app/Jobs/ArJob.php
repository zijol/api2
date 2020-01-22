<?php

namespace App\Jobs;

use App\Enums\RequestMethodEnum;
use App\Services\Http\HttpClient;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ArJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $arEvent = [];

    /**
     * Create a new job instance.
     *
     * @param array $arEvent
     * @return void
     */
    public function __construct($arEvent)
    {
        $this->arEvent = $arEvent;
    }

    /**
     * @throws \ReflectionException
     */
    public function handle()
    {
        $headers = is_array($this->arEvent['headers']) ? $this->arEvent['headers'] : [];
        $httpClient = new HttpClient(['headers' => $headers]);

        $data = is_array($this->arEvent['data']) ? $this->arEvent['data'] : [];
        switch (strtoupper($this->arEvent['method'])) {
            case RequestMethodEnum::GET:
                $httpClient->get($this->arEvent['url'], $data);
                break;
            case RequestMethodEnum::POST:
                $httpClient->post($this->arEvent['url'], $data);
                break;
            case RequestMethodEnum::PUT:
                $httpClient->put($this->arEvent['url'], $data);
                break;
            case RequestMethodEnum::DELETE:
                $httpClient->put($this->arEvent['url'], $data);
                break;
            default:
                $httpClient->get($this->arEvent['url'], $data);
                break;
        }
    }
}
