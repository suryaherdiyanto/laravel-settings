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

		if (config('setting.mode') === 'view') {
			Blade::directive('rendersettings', function($expression) {
				return "<?php echo renderSettings($expression); ?>";
			});
	
			Blade::directive('settings', function($expression) {
				return  "<?php echo settings($expression); ?>";
			});
		} else {
			$statement = 'You currently in <b>api</b> setting mode please change it to <b>view</b> in <b>setting.php</b>';

			Blade::directive('rendersettings', function($expression) use($statement) {
				return $statement;
			});
	
			Blade::directive('settings', function($expression) use($statement) {
				return  $statement;
			});
		}
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