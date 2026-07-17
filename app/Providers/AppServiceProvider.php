<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Http;
use App\Helpers\Telegram;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
      $this->app->bind(Telegram::class, function($app) {
        return new Telegram();
      });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
      Http::macro('polza', function () {
        return Http::timeout(180)->baseUrl("https://api.polza.ai/api/v1/chat/completions")->withHeaders([
          'Authorization' => 'Bearer ' . config('apis.polza_key'),
          'Content-Type' => 'application/json',
        ]);
      });
      
      Http::macro('wordstatAPI', function () {
        return Http::timeout(180)->baseUrl("https://searchapi.api.cloud.yandex.net/v2/wordstat")->withHeaders([
          'Authorization' => 'Api-Key ' . config('apis.yandex.ai_studio_api_key'),
          'Content-Type' => 'application/json',
        ]);
      });
      
      Http::macro('tgBot', function () {
        return Http::baseUrl("https://api.telegram.org/bot" . config('bot.token'))->withHeaders([
          'Content-Type' => 'application/json',
        ]);
      });
      
      // запрос именно для API отчетов. пока для теста к счетчику MYDEV, не. // ?id=91594683
      Http::macro('ymReport', function () {
        return Http::baseUrl("https://api-metrika.yandex.net/stat/v1/data")->withHeaders([
          //'Content-Type' => 'application/json',
          'Content-Type' => 'application/x-yametrika+json',
          'Authorization' => 'OAuth ' . config('app.ym_token')
        ]);
      });
    }
}
