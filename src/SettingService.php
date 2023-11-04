<?php

namespace Surya\Setting;

use Surya\Setting\Repositories\SettingRepository;

class SettingService
{
    private $setting;

    public function __construct(SettingRepository $setting)
    {
        $this->setting = $setting;
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
         return $this->setting->getByGroup($group, [])->keyBy('name');
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
