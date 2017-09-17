<?php namespace FelipeeDev\Preferences;

use FelipeeDev\Utilities\RepositoryInterface;
use FelipeeDev\Utilities\RepositoryTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Repository implements RepositoryInterface
{
    use RepositoryTrait;

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
        return $this->ownerModel->newQuery()
            ->select(
                'auth_preferences.id',
                sprintf('%s.id as value_id', Values\Value::TABLE),
                'key',
                \DB::raw(sprintf(
                    'CASE WHEN %1$s.id IS NULL THEN default_value ELSE %1$s.value END AS value',
                    Values\Value::TABLE
                )),
                'default_value',
                'type',
                'config',
                'created_at',
                'updated_at'
            )
            ->leftJoin(Values\Value::TABLE, 'auth_preference_id', '=', 'auth_preferences.id');
    }

    public function getOwners(Model $owner): OwnersCollection
    {
        return $this->ownersQuery()->owners($owner)->get();
    }
}
