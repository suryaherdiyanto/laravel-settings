<?php 

if (!function_exists('renderSettings')) {
    function renderSettings(string $filename){
        $settings = app('settings');
        $view = '';
        $i = 0;

        $settings_data = $settings->readSettingFile($filename . '.php');

        foreach($settings_data as $value => $data){
            $view .= $settings->renderSetting(array_merge($data, ['i' => $i]), $value);
        }

        return $view;
    }
}

if(!function_exists('settings')){
    function settings($key){
        $settings = app('settings');
        $keys = explode('.', $key);
        return $settings->setting->get($keys[0], $keys[1]);
    }
}