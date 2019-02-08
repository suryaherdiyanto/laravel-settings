<?php

namespace Setting;

use Setting\Repositories\EloquentRepositories\EloquentSettingRepository;
use Setting\Exceptions\SettingTypeNotFoundException;

class SettingService
{
    private $setting_path;
    public $setting;

    public function __construct(EloquentSettingRepository $setting)
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
        return include($this->setting_path . '/' . $filename . '.php');
    }

    /**
     * Get setting from setting file
     * 
     * @return string|false
     */

    public function getSetting(string $key)
    {
        $filename = explode('.', $key)[0];
        $settings = $this->readSettingFile(ltrim($filename));
        $keys = ltrim(str_replace($filename, '', $key), '.');

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
     * @return Setting\Models\Setting
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

    /**
     * Render the setting view
     * 
     * @return view
     */

    public function renderSetting(array $data, string $name)
    {
        switch ($data['type']) {
            case 'text':
                return view('setting::settings.text', array_merge($data, ['name' => $name]))->render();
                break;

            case 'textarea':
                return view('setting::settings.text', array_merge($data, ['name' => $name]))->render();
                break;
            
            default:
                throw new SettingTypeNotFoundException('Setting type '.$data['type']." is not defined");
                break;
        }
    }
}
