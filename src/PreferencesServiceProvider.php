<?php namespace FelipeeDev\Preferences;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

/**
 * Auth package service provider class.
 *
 * Class AuthServiceProvider
 */
class PreferencesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/preferences'),
        ]);
        $this->commands([
            'FelipeeDev\Preferences\Console\PreferenceTablesCommand'
        ]);

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'preferences');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'preferences');
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        if (!\File::exists(base_path() . '/bootstrap/cache/config.php')) {
            $this->mergeConfigFrom(__DIR__ . '/../config/preferences.php', 'preferences');
        }

        $this->app->singleton('preferences', function () {
            return new Service;
        });
    }
}
