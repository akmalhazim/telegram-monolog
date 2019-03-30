<?php

namespace Telegram;

use Illuminate\Support\ServiceProvider;

class TelegramServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->publishes([__DIR__ . '/../config/telegram.config.php' => $this->config_path('telegram.php')], 'config');
    }


    public function register()
    {

    }

    private function config_path($path = '') {
        return app()->basePath() . '/config' . ($path ? '/' . $path : $path);
    }
}
?>