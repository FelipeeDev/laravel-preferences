<?php namespace FelipeeDev\Preferences;

use FelipeeDev\Utilities\Eloquent\ModelRepository;
use FelipeeDev\Preferences\Values\Repository as ValueRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Repository extends ModelRepository
{
    /**
     * @var Preference
     */
    protected $model;

    /**
     * @var OwnersPreference
     */
    protected $ownerModel;

    /**
     * Preference's repository constructor.
     *
     * @param Preference $preference
     * @param OwnersPreference $ownersPreference
     */
    public function __construct(Preference $preference, OwnersPreference $ownersPreference)
    {
        $this->model = $preference;
        $this->ownerModel = $ownersPreference;
    }

    /**
     * Find a preference model by its primary key or slug.
     *
     * @param int|string $id
     * @param array $columns
     * @return Preference|null
     */
    public function find($id, array $columns = ['*'])
    {
        if (is_numeric($id)) {
            return $this->query()->find($id, $columns);
        }

        return $this->query()->where('key', $id)->first($columns);
    }

    /**
     * Constructs an base preference owner's query.
     *
     * @return Builder
     */
    public function ownersQuery(): Builder
    {
        $preferencesTableName = $this->getModel()->getTable();
        $valuesTableName = app(ValueRepository::class)->getModel()->getTable();

        return $this->ownerModel->newQuery()
            ->select(
                $preferencesTableName . '.id',
                sprintf('%s.id as value_id', $valuesTableName),
                'key',
                \DB::raw(sprintf(
                    'CASE WHEN %1$s.id IS NULL THEN default_value ELSE %1$s.value END AS value',
                    $valuesTableName
                )),
                'default_value',
                'type',
                'config',
                'created_at',
                'updated_at'
            )
            ->leftJoin($valuesTableName, 'preference_id', '=', $this->getModel()->getTable() . '.id');
    }

    public function getOwners(Model $owner): OwnersCollection
    {
        return $this->ownersQuery()->owners($owner)->get();
    }
}
