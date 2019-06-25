<?php 

namespace Surya\Setting\Repositories\EloquentRepositories;

use Surya\Setting\Repositories\SettingRepository;
use Surya\Setting\Models\Setting;

class EloquentSettingRepository implements SettingRepository {

    private $model;

    public function __construct()
    {
        $this->model = new Setting;
    }

    /**
     * Get all settings from database
     * 
     * @return Illuminate\Support\Collection
     */

    public function all(array $cols = [])
    {
        if (count($cols) > 0) {
            return $this->model->select($cols)->get();         
        }
        return $this->model->all();
    }

    /**
     * Find setting by id
     * 
     * @return Surya\Setting\Model\Setting
     */

    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Insert new setting
     * 
     * @return Surya\Setting\Model\Setting
     */

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Get setting object from database
     * 
     * @param string $group
     * @param string $name
     * @return Surya\Setting\Model\Setting
     */

    public function getSetting(string $group, string $name)
    {
        return $this->model->where('group', $group)->where('name', $name)->first();
    }

    /**
     * Get setting value from database
     * 
     * @param string $group
     * @param string $name
     * @return mix
     */

    public function get(string $group, string $name)
    {
        $setting = $this->getSetting($group, $name);
        return ($setting) ? $setting->value : setting($group . '.' . $name . '.' . 'default');
    }

    /**
     * Get settings value based on given group from database
     * 
     * @param string $group
     * @param array $cols
     * @return Illuminate\Support\Collection
     */

    public function getByGroup(string $group, array $cols = ['name', 'value'])
    {
        return $this->model->select($cols)->where('group', $group)->get();
    }

    /**
     * Save settings
     * 
     * @param array $data
     * @return void
     */

    public function save(array $data)
    {
        $len = count($data['name']);
        if (count($data['name']) !== count($data['value'])) {
            for ($i=0; $i < $len; $i++) { 
                if(setting($data['group'].'.'.$data['name'][$i].'.type') === 'check'){
                    $setting = $this->getSetting($data['group'], $data['name'][$i]);
                    $setting->value = '';
                    $setting->save();
                    
                    array_splice($data['name'], $i, 1);
                    $len = count($data['name']);
                }
            }
        }
        for ($i=0; $i < $len; $i++) { 
            $this->model->updateOrCreate([
                'name'  => $data['name'][$i],
                'group' => $data['group']
            ], ['value' => isset($data['value'][$i]) ? $data['value'][$i]:'']);
        }
    }

    /**
     * Check if setting exists
     * 
     * @param string $group
     * @param string $name
     * @return bollean
     */

    public function ifExists(string $group, string $name){
        return $this->model->where('group', $group)->where('name', $name)->first() ? true:false;
    }

}