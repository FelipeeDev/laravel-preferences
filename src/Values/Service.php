<?php namespace FelipeeDev\Preferences\Values;

use FelipeeDev\Preferences\Preference;
use FelipeeDev\Utilities\Eloquent\ModelCrud;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Service
 * @package FelipeeDev\Preferences\Values
 *
 * @method Value crudCreate(array $input = [], array $options = [])
 */
class Service
{
    use ModelCrud {
        create as crudCreate;
    }

    protected $dependencies = [
        'repository' => Repository::class,
        'rules' => Rules::class,
    ];

    public function create(Model $owner, Preference $preference, array $input = [], array $options = []): Value
    {
        $input['owner_id'] = $owner->getKey();
        $input['owner_type'] = $owner->getMorphClass();
        $input['preference_id'] = $preference->getKey();

        $value = $this->crudCreate($input, $options);
        $value->setRelation('owner', $owner);
        $value->setRelation('preference', $preference);
        return $value;
    }
}
