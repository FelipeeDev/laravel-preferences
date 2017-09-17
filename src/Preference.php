<?php namespace FelipeeDev\Preferences;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Preference
 * @package FelipeeDev\Preferences
 *
 * @property int id
 * @property string key
 * @property string owner_type
 * @property mixed default_value
 * @property string type
 * @property array config
 */
class Preference extends Model
{
    public $timestamps = false;

    protected $fillable = ['key', 'default_value', 'type', 'config'];

    protected $casts = [
        'config' => 'array'
    ];

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return config('preferences.table', 'preferences');
    }

}
