<?php  namespace FelipeeDev\Preferences;

use FelipeeDev\Preferences\Values\Repository as ValueRepository;
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

        $valuesTableName = app(ValueRepository::class)->getModel()->getTable();
        $query->where(sprintf('%s.owner_id', $valuesTableName), $owner);
        $query->where(sprintf('%s.owner_type', $valuesTableName), $ownerType);
        $query->where(sprintf('%s.owner_type', $this->getTable()), $ownerType);
    }

    public function newCollection(array $models = [])
    {
        return new OwnersCollection($models);
    }
}
