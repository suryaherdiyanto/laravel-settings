<?php

namespace Surya\Setting;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\View;
use Surya\Setting\Exceptions\SettingLabelNotSpecifiedException;
use Surya\Setting\Exceptions\SettingTypeNotFoundException;

use function Orchestra\Testbench\workbench_path;

class SettingUtil
{
    private $resourcePath;

    public function __construct()
    {
        $this->resourcePath = workbench_path('resources/settings');
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

    public function renderFromFile(string $filename)
    {
        $data = $this->readFile($filename);
        $view = '';

        $i = 0;
        foreach ($data as $group => $value) {
            $value['i'] = $i;
            $view .= $this->renderSetting($value, str_replace('.php', '', $filename), $group);
            $i += 1;
        }

        return $view;
    }

    public function renderSetting(array $data, string $group, string $name)
    {
        $data['name'] = $name;
        $data['group'] = $group;
        $this->throwsIfViewDoesntExists($data['type']);

        $data['value'] = app(SettingService::class)->get("{$group}.{$name}");

        if (isset($data['source'])) {

            $data['options'] = [];

            $source = app($data['source']);

            $value = $data['key'] ?? 'id';

            if (!isset($data['show_label'])) {
                throw new SettingLabelNotSpecifiedException("Show Label not specified", 1);
            }

            $dataSource = $source->select([$value, $data['show_label']])->orderBy($value)->get();

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