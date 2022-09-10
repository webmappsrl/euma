<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Kongulov\NovaTabTranslatable\NovaTabTranslatable;
use Laravel\Nova\Fields\MultiSelect;
use Laravel\Nova\Fields\Select;

class ExternalDatabase extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\ExternalDatabase::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id','name'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            NovaTabTranslatable::make([
                Text::make(__('Name'), 'name')->sortable(),
            ]),
            Text::make(__('URL'), 'url'),
            Text::make(__('Mobile APP name'), 'mobile_app_name'),
            MultiSelect::make(__('Mobile APP OS'), 'mobile_app_os')->hideFromIndex()->options([
                'ios' => 'IOS',
                'android' => 'Android',
                'other' => 'Other'
            ]),
            Select::make(__('Offline'), 'offline')->hideFromIndex()->options([
                'yes' => 'Yes',
                'no' => 'No',
                'commercial' => 'Commercial',
            ])->displayUsingLabels(),
            Select::make(__('Download'), 'download')->hideFromIndex()->options([
                'yes' => 'Yes',
                'no' => 'No',
                'commercial' => 'Commercial',
            ])->displayUsingLabels(),
            Select::make(__('Scope'), 'scope')->hideFromIndex()->options([
                'global' => 'Global',
                'continental' => 'Continental',
                'state' => 'State',
                'regional' => 'Regional',
                'local' => 'Local',
            ])->displayUsingLabels(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
