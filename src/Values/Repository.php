<?php namespace FelipeeDev\Preferences\Values;

use FelipeeDev\Preferences\Preference;
use FelipeeDev\Utilities\RepositoryInterface;
use FelipeeDev\Utilities\RepositoryTrait;
use Illuminate\Database\Eloquent\Model;

class Repository implements RepositoryInterface
{
    use RepositoryTrait;

    /**
     * @var Value
     */
    protected $model;

    /**
     * Preference's repository constructor.
     *
     * @param Value $preferenceValue
     */
    public function __construct(Value $preferenceValue)
    {
        $this->model = $preferenceValue;
    }

    /**
     * @param Model $owner
     * @param int|string|Preference $preference
     * @return Value|null
     */
    public function findByPreference(Model $owner, $preference)
    {
        if ($preference instanceof Preference || is_integer($preference)) {
            $id = is_integer($preference) ? $preference : $preference->getKey();
            return $this->query()->owners($owner)->where('auth_preference_id', $id)->first();
        }

        return $this->query()
            ->select($this->getModel()->getTable() . '.*')
            ->join('auth_preferences', 'auth_preferences.id', '=', 'auth_preference_id')
            ->where('key', $preference)
            ->first();
    }
}
