<?php

namespace Lomkit\Rest\Support;

final class Fields
{
    /**
     * Pivot a positional [{name, value}] field list into a name => value map.
     *
     * Both the validation of the declared field rules and the execution that follows it go through
     * this method, so an action or an instruction receives the exact shape that was validated. Only
     * actions can carry an uploaded file: their fields are read from the request root, where multipart
     * can reach them, while instruction fields sit inside the search payload.
     *
     * An entry that is not an array, or whose name is not a string, cannot be keyed and is dropped.
     */
    public static function pivot(mixed $fields): array
    {
        return collect(is_array($fields) ? $fields : [])
            ->filter(function ($field) {
                return is_array($field) && is_string($field['name'] ?? null);
            })
            ->pluck('value', 'name')
            ->all();
    }
}
