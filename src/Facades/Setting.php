<?php

namespace Surya\Setting\Facades;

use Illuminate\Support\Facades\Facade;
use Surya\Setting\SettingService;

class Setting extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return SettingService::class;
    }

}
