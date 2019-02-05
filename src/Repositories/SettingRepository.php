<?php

namespace Setting\Repositories;

interface SettingRepository{
    
    public function find(integer $id);

    public function all();

    public function create(array $data);

    public function get(string $group, string $name);
}