<?php 

namespace Surya\Setting\Repositories\EloquentRepositories;

use Surya\Setting\Repositories\SettingRepository;
use Surya\Setting\Models\Setting;

class EloquentSettingRepository implements SettingRepository {

    private $model;

    public function __construct(Setting $setting)
    {
        $this->model = $setting;
    }

    public function all(array $cols)
    {
        if (count($cols) > 0) {
            return $this->model->select($cols)->all();         
        }
        return $this->model->all();
    }

    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function getSetting(string $group, string $name){
        return $this->model->where('group', $group)->where('name', $name)->first();
    }

    public function get(string $group, string $name)
    {
        $setting = $this->getSetting($group, $name);
        return ($setting) ? $setting->value:setting($group . '.' . $name . '.' . 'default');
    }

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

    public function ifExists(string $group, string $name){
        return $this->model->where('group', $group)->where('name', $name)->first() ? true:false;
    }

}