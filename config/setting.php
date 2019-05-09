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

];