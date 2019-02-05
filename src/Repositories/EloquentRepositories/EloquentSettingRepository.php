<?php 

namespace Setting\Repositories\EloquentRepositories;

use Setting\Repositories\SettingRepository;
use Setting\Models\Setting;

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

    public function get(string $group, string $name){
        $setting = $this->model->where('group', $group)->where('name', $name)->first();
        if($setting){
            return $setting->value;
        }
        return false;
    }

    public function save(array $data)
    {
        $len = count($data['name']);
        for ($i=0; $i < $len; $i++) { 
            $this->model->updateOrCreate([
                'name'  => $data['name'][$i],
                'group' => $data['group']
            ], ['value' => $data['value'][$i]]);
        }
    }

}