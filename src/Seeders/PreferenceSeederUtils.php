<?php namespace FelipeeDev\Preferences\Seeders;

use DB;

trait PreferenceSeederUtils
{
    /**
     * Add multiply preferences to database.
     *
     * @param array $preferences
     */
    protected function addPreferences(array $preferences)
    {
        foreach ($preferences as $key => $input) {
            $this->addPreference($key, $input);
        }
    }

    /**
     * Add new preference to database.
     *
     * @param string $key
     * @param array $input
     */
    protected function addPreference($key, array $input)
    {
        $preferenceTable = app('preferences.repository')->getModel()->getTable();

        if (!DB::table($preferenceTable)->where('key', $key)->count()) {
            DB::table($preferenceTable)->insert(['key' => $key] + $input);
        }
    }
}
