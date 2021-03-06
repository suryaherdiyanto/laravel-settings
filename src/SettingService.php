<?php

namespace Surya\Setting;

use Illuminate\Support\Arr;
use Surya\Setting\Repositories\EloquentRepositories\EloquentSettingRepository;
use Surya\Setting\Exceptions\SettingTypeNotFoundException;
use Surya\Setting\Exceptions\SettingLabelNotSpecifiedException;
use Surya\Setting\Repositories\SettingRepository;

class SettingService
{
    private $setting_path;
    private $setting;

    public function __construct()
    {
        $this->setting_path = resource_path('settings');
        $this->setting = app(SettingRepository::class);
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

        return Arr::get($settings, $keys, 0);
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
     * @return Surya\Setting\Model\Setting
     */
    public function save(array $data)
    {
        return $this->setting->save($data);
    }

    /**
     * Render the setting view
     * 
     * @param array $data
     * @return View
     */
    public function renderSetting(array $data)
    {
        if(!view()->exists('setting::settings.'.$data['type'])){
            throw new SettingTypeNotFoundException('Setting type '.$data['type']." is not defined");
        }

        if (isset($data['source'])) {
            
            $data['options'] = [];

            if (!isset($data['show_label'])) {
                throw new SettingLabelNotSpecifiedException("Show Label not specified", 1);
            }
            
            $source = new $data['source'];

            $value = isset($data['key']) ?: 'id';


            $dataSource = $source->select([$value, $data['show_label']])->orderBy($value)->get();
            unset($source);
            
            if (isset($dataSource)) {
                $sourceCount = $dataSource->count();
                $dataSource = $dataSource->toArray();
    
                for ($i=0; $i < $sourceCount; $i++) { 
                    $data['options'][$dataSource[$i]['id']] = $dataSource[$i][$data['show_label']];
                }
            }

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
