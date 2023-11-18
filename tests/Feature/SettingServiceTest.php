<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase;
use Surya\Setting\SettingUtil;
use Surya\Setting\SettingService;
use Workbench\Database\Seeders\SettingSeeder;

class SettingServiceTest extends TestCase
{
    use RefreshDatabase, WithWorkbench;

    protected function defineDatabaseMigrations()
    {
        $this->loadMigrationsFrom(dirname(__DIR__) . '/database/migrations');
    }

    public function test_if_exists_true()
    {
        $this->seed(SettingSeeder::class);
        $this->assertTrue(app(SettingService::class)->exists('general', 'test'));
    }

    public function test_get_setting_and_return_the_value()
    {
        $this->seed(SettingSeeder::class);
        $this->assertEquals('1', app(SettingService::class)->get('general.test'));
    }

    public function test_return_the_default_value_if_the_setting_key_doesnt_exists()
    {
        $this->partialMock(SettingUtil::class)
                ->shouldReceive('getSettingProp')
                ->andReturn('default');
        $this->seed(SettingSeeder::class);
        $this->assertEquals('default', app(SettingService::class)->get('general.test2'));
    }
}