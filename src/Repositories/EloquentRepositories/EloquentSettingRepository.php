<?php 

namespace Repositories\EloquentRepositories;

use Setting\Repositories\SettingRepository;
use Setting\Models\Setting;

class EloquentSettingRepositories implements SettingRepository {

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

    public function find(integer $id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function get(string $group, string $name){
        return $this->model->where('group', $group)->andWhere('name', $name)->first();
    }

}