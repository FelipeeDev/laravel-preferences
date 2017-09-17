<?php namespace FelipeeDev\Preferences\Providers;

use FelipeeDev\Preferences\Observers\PreferenceValueObserver;
use FelipeeDev\Preferences\Values\Value;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        //
    ];

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [
        //
    ];

    /**
     * Register any other events for your application.
     */
    public function boot()
    {
        parent::boot();
        Value::observe(PreferenceValueObserver::class);
    }
}
