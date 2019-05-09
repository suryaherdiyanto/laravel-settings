<?php

namespace Surya\Setting\Repositories;

interface SettingRepository{
    
    public function find(int $id);

    public function all(array $cols);

    public function create(array $data);

    public function get(string $group, string $name);

    public function getByGroup(string $group, array $cols);

    public function save(array $data);

    public function ifExists(string $group, string $name);
}