<?php

namespace Surya\Setting;

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
		$this->app->singleton('setting', function($app){
			return new SettingService(new Models\Setting);
		});
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
		$this->publishes([
			__DIR__.'/../resources/views/settings' => resource_path('views/vendor/setting/settings')
		], 'views');
	}
}