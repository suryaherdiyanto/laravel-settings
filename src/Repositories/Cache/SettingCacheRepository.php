<?php

namespace Surya\Setting\Repositories\Cache;

use Surya\Setting\Repositories\SettingRepository;
use Surya\Setting\Repositories\EloquentRepositories\EloquentSettingRepository;
use Cache;

class SettingCacheRepository implements SettingRepository
{

    private $cacheTime;
    private $repository;

    public function __construct() {
        $this->repository = new EloquentSettingRepository;
        $this->cacheTime = config('setting.cache_time');
    }

    public function find($id) {
        return Cache::remember('Setting.find.'.$id, $this->cacheTime, function() use($id) {
            return $this->repository->find($id);
        });
    }

    public function all(array $cols) {
        return Cache::remember('Setting.all', $this->cacheTime, function() use($cols) {
            return $this->repository->all($cols);
        });
    }

    public function create(array $data) {
        $this->clearCache();
        return $this->repository->create($data);
    }

    public function get(string $group, string $name) {
        return Cache::remember('Setting.get.'.$group.'.'.$name, $this->cacheTime, function() use($group, $name) {
            return $this->repository->get($group, $name);
        });
    }

    public function getByGroup(string $group, array $cols = ['name', 'value']) {
        return Cache::remember('Setting.getByGroup.'.$group, $this->cacheTime, function() use($group, $cols) {
            return $this->repository->getByGroup($group, $cols);
        });
    }

    public function save(array $data) {
        $this->clearCache();
        return $this->repository->save($data);
    }

    public function ifExists(string $group, string $name) {
        return $this->repository->ifExists($group, $name);
    }

    /**
     * Forget all stored cache
     * 
     * @return void
     */

    private function clearCache() {
        Cache::forget('Setting.all');

        $settings = $this->repository->all(['id', 'group', 'name']);
        foreach ($settings as $setting) {
            $setting_id = 'Setting.find'.$setting->id;
            $setting_get = 'Setting.get.'.$setting->group.'.'.$setting->name;
            $setting_group = 'Setting.getByGroup.'.$setting->group;

            if (Cache::has($setting_id)) {
                Cache::forget($setting_id);
            }

            if (Cache::has($setting_get)) {
                Cache::forget($setting_get);
            }

            if (Cache::has($setting_group)) {
                Cache::forget($setting_group);
            }
        }
    }
    
}
