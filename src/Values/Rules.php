<?php namespace FelipeeDev\Preferences\Values;

use FelipeeDev\Utilities\Validation\Rules as RulesInterface;

class Rules implements RulesInterface
{
    public function getRules(string $type = null): array
    {
        return [
            'auth_preference_id' => 'required'
        ];
    }
}
