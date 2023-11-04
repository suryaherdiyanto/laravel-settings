<?php

use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase;
use Surya\Setting\Exceptions\SettingTypeNotFoundException;
use Surya\Setting\SettingService;
use Surya\Setting\SettingUtil;

class SettingUtilTest extends TestCase
{
    use WithWorkbench;
    public function test_get_the_setting_props()
    {
        $this->partialMock(SettingUtil::class)
                ->shouldReceive('readFile')
                ->andReturn([
                    'site_name' => [
                        'type' => 'text',
                        'default' => 'test'
                    ]
                ]);
        $this->assertEquals('text', app(SettingUtil::class)->getSettingProp('general.site_name.type'));
    }

    public function test_return_null_if_props_are_not_defined()
    {
        $this->partialMock(SettingUtil::class)
                ->shouldReceive('readFile')
                ->andReturn([
                    'site_name' => [
                        'type' => 'text',
                        'default' => 'test'
                    ]
                ]);
        $this->assertEquals(null, app(SettingUtil::class)->getSettingProp('general.invalid.type'));
    }

    public function test_render_setting_with_correct_view()
    {
        $this->mock(SettingService::class)
            ->shouldReceive('get')->once()->andReturn('default');
        $this->assertStringContainsString('type="text"', app(SettingUtil::class)->renderSetting([
            'type' => 'text',
            'default' => 'test',
            'label' => 'test',
            'i' => 0
        ], 'general', 'site_name'));
    }

    public function test_should_throw_error_if_setting_type_is_not_available()
    {
        $this->assertThrows(function() {
            app(SettingUtil::class)->renderSetting([
                'type' => 'invalid',
                'default' => 'test',
                'label' => 'test',
                'i' => 0
            ], 'general', 'site_name');
        }, SettingTypeNotFoundException::class);
    }
}