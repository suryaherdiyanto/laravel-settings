<?php

return [

    /**
     * Set setting cache time
     */

    'cache_time'    => now()->addHours(2),

    /**
     * Enable or disable setting cache
     */
    'caching'       => env('SETTING_CACHE', true),

    /**
     * Mode for retrive setting html supported view and api
     */
     'mode'         => env('SETTING_MODE', 'view')

];