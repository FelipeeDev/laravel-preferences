<?php

if (! function_exists('preference')) {
    /**
     * Get owner's preference value.
     *
     * @param \Illuminate\Database\Eloquent\Model $owner
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function preference(\Illuminate\Database\Eloquent\Model $owner, string $key, $default = null)
    {
        return app('preferences')->getValue($owner, $key, $default);
    }
}
