<?php

namespace Collegeplannerpro\InterviewReport;

/**
 * This class is syntactic sugar to allow accessing array members that might not be set,
 * bypassing the warning
 */
class NullableMemberLookup implements Gettable
{
    private array $array;

    public function __construct(array $array)
    {
        $this->array = $array;
    }

    public function get(string $key)
    {
        if (!array_key_exists($key, $this->array)) {
            return null;
        }

        return $this->array[$key];
    }
}
