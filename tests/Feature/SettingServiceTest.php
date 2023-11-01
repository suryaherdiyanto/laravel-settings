<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase;
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
}