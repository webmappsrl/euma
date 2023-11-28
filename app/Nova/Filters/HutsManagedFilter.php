<?php

namespace App\Nova\Filters;

use Laravel\Nova\Filters\BooleanFilter;
use Laravel\Nova\Http\Requests\NovaRequest;

class HutsManagedFilter extends BooleanFilter
{
    /**
     * Apply the filter to the given query.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(NovaRequest $request, $query, $value)
    {

        //if 2 values are selected, we want to show all huts
        if ($value['Managed'] && $value['Not Managed'] || $value == null || !$value['Managed']  && !$value['Not Managed']) {
            return $query;
        }
        if ($value['Not Managed'])
            return $query->where('managed', false);
        if ($value['Managed'])
            return $query->where('managed', true);
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function options(NovaRequest $request)
    {
        return [
            true => 'Managed',
            false => 'Not Managed'
        ];
    }
}
