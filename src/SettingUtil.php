<?php

namespace Surya\Setting;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\View;
use Surya\Setting\Exceptions\SettingLabelNotSpecifiedException;
use Surya\Setting\Exceptions\SettingTypeNotFoundException;

class SettingUtil
{
    private $resourcePath;

    public function __construct()
    {
        $this->resourcePath = resource_path('settings');
    }

    public function readFile(string $filename): array
    {
        return include($this->resourcePath . '/' . $filename . '.php');
    }

    public function getSettingProp(string $key)
    {
        $filename = explode('.', $key)[0];
        $settings = $this->readFile(ltrim($filename));
        $keys = ltrim(str_replace($filename, '', $key), '.');

        return Arr::get($settings, $keys, 0);
    }

    private function throwsIfViewDoesntExists(string $view)
    {
        if(!View::exists('setting::settings.'.$view)){
            throw new SettingTypeNotFoundException("Setting type {$view} is not defined");
        }
    }

    private function throwsIfLabelNotSpecified(string|null $label = null)
    {
        if (!isset($type)) {
            throw new SettingLabelNotSpecifiedException("Show Label not specified", 1);
        }
    }

    public function renderSetting(array $data, string $group, string $name)
    {
        $data['name'] = $name;
        $data['group'] = $group;
        $this->throwsIfViewDoesntExists($data['type']);

        $data['value'] = app('setting')->get("{$group}.{$name}");

        if (isset($data['source'])) {

            $data['options'] = [];

            $source = new $data['source'];

            $value = isset($data['key']) ?: 'id';

            $this->throwsIfLabelNotSpecified($data['label']);
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

        return View::make('setting::settings.'.$data['type'], $data)->render();

    }
}