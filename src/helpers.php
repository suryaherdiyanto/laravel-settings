<?php 

/**
 * Render the setting file to view
 * 
 * @return string
 */

if (!function_exists('renderSettings')) {
    function renderSettings(string $filename) : string {
        $view = '';
        $i = 0;

        
        $settings_data = Setting::readSettingFile($filename);
        
        
        foreach($settings_data as $key => $data) {

            $view .= Setting::renderSetting(array_merge($data, [
                                'i' => $i, 'group' => $filename,
                                'value' => Setting::get($filename . '.' . $key), 
                                'name'  => $key
                                ]
                            )
                        );
            $view .= "<input type='hidden' value='$key' name='name[]'>";
            $i++;
        }
        $view .= "<input type='hidden' value='$filename' name='group'>";

        return $view;
    }
}

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