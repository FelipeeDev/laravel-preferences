<?php namespace FelipeeDev\Preferences;

use FelipeeDev\Utilities\DependenciesTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Preferences service.
 *
 * @property \FelipeeDev\Preferences\Repository repository
 * @property \FelipeeDev\Preferences\Values\Repository valueRepository
 * @property \FelipeeDev\Preferences\Values\Service valueService
 */
class Service
{
    use DependenciesTrait;

    protected $dependencies = [
        'repository' => 'FelipeeDev\Preferences\Repository',
        'valueRepository' => 'FelipeeDev\Preferences\Values\Repository',
        'valueService' => 'FelipeeDev\Preferences\Values\Service',
    ];

    /**
     * @param Model $owner
     * @return OwnersCollection
     */
    public function getOwners(Model $owner): OwnersCollection
    {
        return $this->getOwnersCached($owner);
    }

    /**
     * @param Model $owner Owner model's instance.
     * @param Preference|string|int $preference May be a string key, integer id or a Preference instance.
     * @param mixed $value
     * @return Values\Value
     */
    public function setValue(Model $owner, $preference, $value = null)
    {
        if (!$preference instanceof Preference) {
            $preference = $this->repository->find($preference);
        }

        $preferenceValue = $this->valueRepository->findByPreference($owner, $preference);

        $data = ['value' => $value];

        if ($preferenceValue) {
            $this->valueService->update($preferenceValue, $data);
            return $preferenceValue;
        }

        return $this->valueService->store($owner, $preference, $data);
    }

    /**
     * @param Model $owner
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getValue(Model $owner, $key, $default = null)
    {
        return $this->getOwners($owner)->get($key, $default);
    }

    /**
     * @param Model $owner
     * @param string $cacheKey
     * @return string
     */
    public function getOwnerCacheKey(Model $owner, $cacheKey = null): string
    {
        $cacheKey = $cacheKey ?? config('fd-preferences::cache-key');
        return sprintf("%s.%s_%s.", $cacheKey, $owner->getMorphClass(), $owner->getKey());
    }

    public function forgetOwners(Model $owner)
    {
        \Cache::forget($this->getOwnerCacheKey($owner));
    }

    private function getOwnersCached(Model $owner): OwnersCollection
    {
        return \Cache::rememberForever($this->getOwnerCacheKey($owner), function () use ($owner) {
            return $this->repository->getOwners($owner);
        });
    }
}
