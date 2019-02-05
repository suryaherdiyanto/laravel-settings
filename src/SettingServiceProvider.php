<?php

namespace Setting;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

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

		Blade::directive('settings', function($expression){
			return "<?php echo renderSettings($expression); ?>";
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
			return new SettingService(new Models\Setting);
		});

		$this->app->singleton(\Repositories\SettingRepository::class, \Repositories\EloquentRepositories\EloquentSettingRepository::class);
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