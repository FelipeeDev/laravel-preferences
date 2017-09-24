<?php namespace FelipeeDev\Preferences\Values;

use FelipeeDev\Preferences\Preference;
use EnterCode\Kernel\Presets\Valueable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Value
 *
 * @package FelipeeDev\Preferences
 *
 * @property int id
 * @property int owner_id
 * @property string owner_type
 * @property int preference_id
 * @property mixed value
 * @property \Carbon\Carbon created_at
 * @property \Carbon\Carbon updated_at
 * @property Model owner
 * @property Preference preference
 */
class Value extends Model implements Valueable
{
    protected $fillable = ['preference_id', 'owner_id', 'owner_type', 'value'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function owner()
    {
        return $this->morphTo();
    }

    public function preference()
    {
        return $this->belongsTo(app('preferences')->getRepository());
    }

    /**
     * @param Builder $query
     * @param int|Model $owner Can be id
     * @param string $ownerType (optional)
     */
    public function scopeOwners(Builder $query, $owner, $ownerType = null)
    {
        if ($owner instanceof Model) {
            $ownerType = get_class($owner);
            $owner = $owner->getKey();
        }

        $query->where(sprintf('%s.owner_id', $this->getTable()), $owner);
        $query->where(sprintf('%s.owner_type', $thise->getTable()), $ownerType);
    }

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return config('preferences.values.table', 'preference_values');
    }

    /**
     * Get value from preset's node.
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set value for preset's node.
     *
     * @param mixed $value
     * @param bool $store
     * @return void
     */
    public function setValue($value, $store = true)
    {
        if (!$store) {
            $this->value = $value;
            return;
        }
        $service = app(Service::class);
        $input = ['value' => $value];
        $service->update($this, $input);
    }

    /**
     * If the given value is readonly.
     *
     * @param bool $readonly
     * @return bool
     */
    public function isReadonly($readonly)
    {
        return $readonly;
    }

    /**
     * @return string
     */
    public function getFieldType()
    {
        return $this->preference->type;
    }

    /**
     * @return \EnterCode\Kernel\Fields\FieldOptions
     */
    public function getFieldOptions()
    {
        // TODO: Implement getFieldOptions() method.
    }
}
