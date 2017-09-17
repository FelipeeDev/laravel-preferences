<?php namespace FelipeeDev\Preferences\Observers;

use FelipeeDev\Preferences\Values\Value;

class PreferenceValueObserver
{
    public function saved(Value $value)
    {
        app('preferences')->forgetOwners($value->owner);
    }
}
