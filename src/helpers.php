<?php 

/**
 * Render the setting file to view
 * 
 * @return View
 */

if (!function_exists('renderSettings')) {
    function renderSettings(string $filename){
        $settings = app('settings');
        $view = '';
        $i = 0;

        $settings_data = $settings->readSettingFile($filename . '.php');

        foreach($settings_data as $value => $data){
            $view .= $settings->renderSetting(array_merge($data, ['i' => $i]), $value);
            $view .= "<input type='hidden' value='$value' name='name[]'>";
        }
        $view .= "<input type='hidden' value='$filename' name='group'>";

        return $view;
    }
}

/**
 * Get the setting value from database
 * 
 * @return mix
 */

if(!function_exists('settings')){
    function settings($key){
        $settings = app('settings');
        $keys = explode('.', $key);
        return $settings->setting->get($keys[0], $keys[1]);
    }
}

/**
 * Read the setting file and return the key value
 * 
 * @return mix
 */

if(!function_exists('setting')){
    function settings($key){
        return app('settings')->getSetting($key);
    }
}