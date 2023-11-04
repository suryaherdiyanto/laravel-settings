<?php

namespace Surya\Setting;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Surya\Setting\Repositories\SettingRepository;
use Surya\Setting\Repositories\EloquentRepositories\EloquentSettingRepository;
use Surya\Setting\Repositories\Cache\SettingCacheRepository;

class SettingServiceProvider extends ServiceProvider
{
	/**
	* Bootstrap any application services
	*
	* @return  void
	*/
	public function boot()
	{
		$this->publishFiles();

		$this->loadViewsFrom(__DIR__.'/../resources/views', 'setting');

	}

	/**
	* Register any application services
	*
	* @return  void
	*/
	public function register()
	{
		$this->app->singleton(SettingService::class);

		$this->app->singleton(SettingUtil::class, function() {
			return new SettingUtil;
		});

		$this->app->singleton(SettingRepository::class, function() {
			if (config('setting.caching')) {
				return new SettingCacheRepository;
			}
			return new EloquentSettingRepository;
		});

		$this->mergeConfigFrom(
			__DIR__ . '/../config/setting.php', 'setting'
		);
	}

	/**
	 * Publish required files
	 *
	 * @return void
	 */
	private function publishFiles()
	{
		$this->publishes([
			__DIR__ . '/../database/migrations' => database_path('migrations')
		], 'migrations');

		$this->publishes([
			__DIR__ . '/../resources/views/settings' => resource_path('views/vendor/setting/settings')
		], 'views');

		$this->publishes([
			__DIR__ . '/../config' => config_path()
		], 'config');
	}
}