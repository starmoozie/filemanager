<?php

namespace Starmoozie\FileManager;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class FileManagerServiceProvider extends ServiceProvider
{
    protected $commands = [
        \Starmoozie\FileManager\Console\Commands\Install::class,
    ];

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'starmoozie');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'starmoozie');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the views.
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/elfinder'),
        ], 'views');

        $this->publishes([
            __DIR__.'/../config/elfinder.php'      => config_path('elfinder.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../public/packages/starmoozie/filemanager/themes/starmoozie'      => public_path('packages/starmoozie/filemanager/themes/starmoozie'),
        ], 'public');

        // Registering package commands.
        $this->commands($this->commands);

        // Mapping the elfinder prefix, if missing
        if (! Config::get('elfinder.route.prefix')) {
            Config::set('elfinder.route.prefix', Config::get('starmoozie.base.route_prefix').'/elfinder');
        }
    }
}
