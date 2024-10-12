<?php

namespace Aaronharold\SmsGateway;

use Illuminate\Support\ServiceProvider;

class SmsGatewayProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/smsgateway.php' => config_path('smsgateway.php'),
        ], 'smsgateway-config');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/smsgateway.php',
            'smsgateway'
        );
    }
}
