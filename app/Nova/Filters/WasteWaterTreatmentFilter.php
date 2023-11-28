<?php

namespace App\Nova\Filters;

use Laravel\Nova\Filters\BooleanFilter;
use Laravel\Nova\Http\Requests\NovaRequest;

class WasteWaterTreatmentFilter extends BooleanFilter
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
        if ($value['True'] && $value['False'] || $value == null || !$value['True']  && !$value['False']) {
            return $query;
        }
        if ($value['False'])
            return $query->where('wastewater_treatment', false);
        if ($value['True'])
            return $query->where('wastewater_treatment', true);
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
            true => 'True',
            false => 'False'
        ];
    }

    public function name()
    {
        return __('Wastewater Treatment');
    }
}
