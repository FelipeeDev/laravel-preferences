<?php namespace FelipeeDev\Preferences;

use FelipeeDev\Utilities\Validation\Rules as RulesInterface;

class Rules implements RulesInterface
{
    /**
     * Get's validation rules array.
     *
     * @param string $type
     * @return array
     */
    public function getRules(string $type = null): array
    {
        return [
            'key' => 'required'
        ];
    }
}
