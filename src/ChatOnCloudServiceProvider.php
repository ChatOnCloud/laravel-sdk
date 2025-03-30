<?php 

namespace ChatOnCloud;

use Illuminate\Support\ServiceProvider;
use ChatOnCloud\Ticket\TicketClient;

class ChatOnCloudServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/chatoncloud.php', 'chatoncloud');

        $this->app->singleton(TicketClient::class, function () {
            return new Ticket\TicketClient();
        });
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/chatoncloud.php' => config_path('chatoncloud.php'),
        ], 'chatoncloud-config');
    }
}
