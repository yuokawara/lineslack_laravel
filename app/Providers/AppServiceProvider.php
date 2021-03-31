<?php

namespace App\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;
use LINE\LINEBot;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Bot::macro('verifyWebhook', function (): array {
        //     return Http::line()->post('/v2/bot/channel/webhook/test', [
        //         'endpoint' => '',
        //     ])->json();
        // });

        // Bot::macro('freindshipStatus', function (string $access_token): array {
        //     return Http::line()
        //         ->withToken($access_token)
        //         ->get('/frendship/v1/status')
        //         ->json();
        // });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Line bot
        // $this->app->bind('line-bot', function ($app, array $parameters) {
        //     return new LINEBot(
        //         new LINEBot\HTTPClient\CurlHTTPClient(env('LINE_ACCESS_TOKEN')),
        //         ['channelSecret' => env('LINE_CHANNEL_SECRET')]
        //     );
        // });
    }
}
