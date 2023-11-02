<?php

namespace Surya\Setting\Facades;

use Illuminate\Support\Facades\Facade;

class SettingUtil extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return SettingUtil::class;
    }

}
