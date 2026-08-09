<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

/**
 * Every admin list screen sorts by a column name taken straight from the query
 * string — `$result->orderBy($request->input('sortBy'), $request->input('orderBy'))`
 * in six controllers plus two traits. Column names are not bound parameters, so
 * the value went into the SQL as an identifier, and an unknown column or a
 * direction that was not asc/desc was a 500.
 */
trait SortsQueries
{
    protected function applySort(
        Builder $query,
        Request $request,
        array $allowed,
        string $columnKey = 'sortBy',
        string $directionKey = 'orderBy',
    ): Builder {
        $column = $request->input($columnKey);
        $direction = strtolower((string) $request->input($directionKey)) === 'desc' ? 'desc' : 'asc';

        if (! in_array($column, $allowed, true)) {
            return $query->latest();
        }

        return $query->orderBy($column, $direction);
    }
}
