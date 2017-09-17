<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Preferences cache key
    |--------------------------------------------------------------------------
    |
    | A preferences cache key for preferences to be cached under.
    |
    */
    'cache-key' => env('PREFERENCES_CACHE_KEY', 'preferences'),

    /*
    |--------------------------------------------------------------------------
    | Preferences tables names
    |--------------------------------------------------------------------------
    |
    | Name of a preferences tables.
    |
    */
    'tables' => [
        'preferences' => env('PREFERENCES_TABLE', 'preferences'),
        'preference_values' => env('PREFERENCE_VALUES_TABLE', 'preference_values'),
    ],


];
