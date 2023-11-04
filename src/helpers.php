<?php

/**
 * Get the setting value from database
 *
 * @param string $key
 * @return mix
 */

if(!function_exists('settings')) {
    function settings(string $key){
        return Setting::get($key);
    }
}

/**
 * Read the setting file and return the key value
 *
 * @param string $key
 * @return mix
 */

if(!function_exists('setting')) {
    function setting(string $key){
        return Setting::getSettingProp($key);
    }
}

/**
 * Check if setting already in database or not
 *
 * @param string $group
 * @param string $name
 * @return boolean
 */
if(!function_exists('settingExists')) {
    function settingExists($group, $name) : bool {
        return Setting::exists($group, $name);
    }
}

/**
 * Get file url for file setting type
 *
 * @return string
 */
if (!function_exists('getFileUrl')) {
    function getFileUrl(string $url) : string {
        return Storage::disk(config('filesystem.default'))->url($url);
    }
}