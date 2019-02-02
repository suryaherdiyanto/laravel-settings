<?php

namespace Settings;

use Illuminate\Support\ServiceProvider;

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
	}

	/**
	* Register any application services
	* 
	* @return  void
	*/
	public function register()
	{

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