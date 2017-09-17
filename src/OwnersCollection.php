<?php namespace FelipeeDev\Preferences;

use Illuminate\Support\Collection;

class OwnersCollection extends Collection
{
    /**
     * OwnersCollection constructor.
     * @param array $items
     */
    public function __construct($items = [])
    {
        foreach ($items as $item) {
            if ($key = array_get($item, 'key')) {
                $this->items[$key] = $item;
            }
        }
    }
}
