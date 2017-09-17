<?php  namespace FelipeeDev\Preferences;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class OwnersPreference extends Preference
{
    public $timestamps = true;

    protected $fillable = [];

    /**
     * @param Builder $query
     * @param int|Model $owner Can be id
     * @param string $ownerType (optional)
     */
    public function scopeOwners(Builder $query, $owner, $ownerType = null)
    {
        if ($owner instanceof Model) {
            $ownerType = $owner->getMorphClass();
            $owner = $owner->getKey();
        }

        $query->where(sprintf('%s.owner_id', $this->getValueTable()), $owner);
        $query->where(sprintf('%s.owner_type', $this->getValueTable()), $ownerType);
        $query->where(sprintf('%s.owner_type', $this->table), $ownerType);
    }

    public function newCollection(array $models = [])
    {
        return new OwnersCollection($models);
    }

    private function getValueTable(): string
    {
        return config('preferences.values.table', 'preference_values');
    }
}
