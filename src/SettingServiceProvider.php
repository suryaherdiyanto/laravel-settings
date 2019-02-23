<?php

namespace Setting;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Setting\Repositories\SettingRepository;
use Setting\Repositories\EloquentRepositories\EloquentSettingRepository;

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

		Blade::directive('rendersettings', function($expression){
			return "<?php echo renderSettings($expression); ?>";
		});

		Blade::directive('settings', function($expression){
			return  "<?php echo settings($expression); ?>";
		});
	}

	/**
	* Register any application services
	* 
	* @return  void
	*/
	public function register()
	{
		$this->app->singleton('settings', function($app){
			return new SettingService(new Repositories\EloquentRepositories\EloquentSettingRepository(new Models\Setting));
		});

		$this->app->singleton(SettingRepository::class, EloquentSettingRepository::class);
	}

	/**
	 * Publish required files
	 * 
	 * @return void
	 */
	private function publishFiles()
	{
		$this->publishes([
			__DIR__.'/../database/migrations' => database_path('migrations')
		], 'migrations');
		$this->publishes([
			__DIR__.'/../resources/assets' => resource_path('assets')
		], 'assets');
	}
}