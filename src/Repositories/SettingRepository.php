<?php

namespace Setting\Repositories;

interface SettingRepository{
    
    public function find(int $id);

    public function all(array $cols);

    public function create(array $data);

    public function get(string $group, string $name);

    public function save(array $data);
}