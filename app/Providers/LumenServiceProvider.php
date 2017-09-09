<?php

namespace App\Providers;

use Folklore\GraphQL\LumenServiceProvider as UpstreamServiceProvider;

class LumenServiceProvider extends UpstreamServiceProvider
{
    // Fix for Lumen compatibility
    protected function getRouter()
    {
        return $this->app->router;
    }
}
