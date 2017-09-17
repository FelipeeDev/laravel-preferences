<?php namespace FelipeeDev\Preferences\Values;

use FelipeeDev\Preferences\Preference;
use EnterCode\Kernel\Services\ModelCrud;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Service
 * @package FelipeeDev\Preferences\Values
 *
 * @method Value crudStore(array $input = [], array $options = [])
 */
class Service
{
    use ModelCrud {
        store as crudStore;
    }

    /**
     * @var Repository
     */
    protected $repository = Repository::class;

    /**
     * @var Validator
     */
    protected $validator;

    /**
     * Service constructor.
     *
     * @param Validator $validator
     */
    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    public function store(Model $owner, Preference $preference, array $input = [], array $options = []): Value
    {
        $input['owner_id'] = $owner->getKey();
        $input['owner_type'] = $owner->getMorphClass();
        $input['auth_preference_id'] = $preference->getKey();

        $value = $this->crudStore($input, $options);
        $value->setRelation('owner', $owner);
        $value->setRelation('preference', $preference);
        return $value;
    }
}
