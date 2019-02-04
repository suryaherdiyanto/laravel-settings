<?php

namespace Setting;

use Setting\Models\Setting;

class SettingService
{
    private $setting_path;
    private $setting;

    public function __construct(Setting $setting)
    {
        $this->setting_path = resource_path('settings');
        $this->setting = $setting;
    }

    /**
     * Read the setting file
     * 
     * @return array
     */

    public function readSettingFile(string $filename): array
    {
        return include($filename);
    }

    /**
     * Get setting from setting file
     * 
     * @return string|false
     */

    public function getSetting(string $key)
    {
        $settings = $this->readSettingFile(ltrim(explode('.', $key)[0]));
        $keys = ltrim(str_replace($settings), '.');

        return array_dot($settings)[$keys] ?: false;
    }

    /**
     * Get setting root path
     * 
     * @return string
     */

    public function getSettingPath(): string
    {
        return $this->setting_path;
    }

    /**
     * Save the setting
     * 
     * @return Setting
     */

    public function saveSetting(array $args): Setting
    {
        return $this->setting->create([
            'name'  => $args['name'],
            'group' => $args['group'],
            'value' => $args['value'],
            'type'  => $args['type']
        ]);
    }

    public function renderSetting()
    {
        
    }
}
