<?php

namespace Surya\Setting;

use Surya\Setting\Repositories\EloquentRepositories\EloquentSettingRepository;
use Surya\Setting\Exceptions\SettingTypeNotFoundException;
use Surya\Setting\Models\Setting;

class SettingService
{
    private $setting_path;
    private $setting;

    public function __construct(Setting $setting)
    {
        $this->setting_path = resource_path('settings');
        $this->setting = new EloquentSettingRepository($setting);
    }

    /**
     * Get all settings from database
     * 
     * @return Illuminate\Support\Collection
     */

    public function all(array $cols = ['name', 'value'])
    {
        return $this->setting->all($cols)->keyBy('name');
    }

    /**
     * Get all settings based on given group
     * 
     * @return Illuminate\Support\Collection
     */

     public function getByGroup(string $group)
     {
         return $this->setting->getByGroup($group)->keyBy('name');
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
     * Get setting value from database
     * 
     * @param string $key
     * @return mix
     */
    public function get(string $key)
    {
        $keys = explode('.', $key);
        return $this->setting->get($keys[0], $keys[1]);
    }

    /**
     * Get setting from setting file
     * 
     * @param $key
     * @return string|false
     */
    public function getSettingProp(string $key)
    {
        $filename = explode('.', $key)[0];
        $settings = $this->readSettingFile(ltrim($filename));
        $keys = ltrim(str_replace($filename, '', $key), '.');

        return isset(array_dot($settings)[$keys]) ? array_dot($settings)[$keys] : false;
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
     * Save settings data to database
     * 
     * @param array $data
     * @return Surya\Setting\Model\Settings
     */
    public function save(array $data)
    {
        return $this->setting->save($data);
    }

    /**
     * Render the setting view
     * 
     * @param array $data
     * @return view
     */
    public function renderSetting(array $data)
    {
        if(!view()->exists('setting::settings.'.$data['type'])){
            throw new SettingTypeNotFoundException('Setting type '.$data['type']." is not defined");
        }
        return view('setting::settings.'.$data['type'], $data)->render();
        
    }

    /**
     * Check if setting already in database or not
     * 
     * @param string $group
     * @param string $name
     * @return boolean
     */
    public function exists(string $group, string $name)
    {
        return $this->setting->ifExists($group, $name);
    }
}
