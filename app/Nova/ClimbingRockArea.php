<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Kongulov\NovaTabTranslatable\NovaTabTranslatable;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\URL;
use Wm\MapPoint\MapPoint;

class ClimbingRockArea extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\ClimbingRockArea::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id','name'
    ];

    /**
     * Build an "index" query for the given resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        if ($request->user()->is_admin == true) {
            return $query;
        } else if ($request->user()->member) {
            return $query->where('member_id', $request->user()->member->id);
        } else {
            return null;
        }
    }

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
                Textarea::make(__('Description'), 'description')->hideFromIndex(),
                Text::make(__('Alternative name'), 'alternative_name'),
            ]),

            MapPoint::make('geometry')->withMeta([
                'center' => ["42", "10"],
                'attribution' => '<a href="https://webmapp.it/">Webmapp</a> contributors',
                'tiles' => 'https://api.webmapp.it/tiles/{z}/{x}/{y}.png',
                'minZoom' => 5,
                'maxZoom' => 16,
                'defaultZoom' => 5
            ]),
            URL::make(__('URL'), 'url')->displayUsing(fn () => "$this->url")->hideFromIndex(),
            URL::make(__('Local rules url'),'local_rules_url')->displayUsing(fn () => "$this->local_rules_url")->hideFromIndex(),
            NovaTabTranslatable::make([
                Textarea::make(__('Local rules description'), 'local_rules_description'),
            ])->hideFromIndex(),
            
            // TODO: local_rules_document upload file
            
            Boolean::make(__('Local restrictions'),'local_restrictions')->hideFromIndex(),
            NovaTabTranslatable::make([
                Textarea::make(__('Local restrictions description'), 'local_restrictions_description')->sortable(),
            ])->hideFromIndex(),

            MapPoint::make(__('Parking position'),'parking_position')->withMeta([
                'center' => ["42", "10"],
                'attribution' => '<a href="https://webmapp.it/">Webmapp</a> contributors',
                'tiles' => 'https://api.webmapp.it/tiles/{z}/{x}/{y}.png',
                'minZoom' => 5,
                'maxZoom' => 16,
                'defaultZoom' => 5
            ])->hideFromIndex(),

            Select::make(__('Location quality'), 'location_quality')->hideFromIndex()->options([
                1 => 'Good routes, but a bad area a quarry',
                2 => 'A good location, and good climbing moves',
                3 => 'An exceptional location with memorable routes'
            ])->displayUsingLabels(),

            Number::make(__('Routes number'),'routes_number'),
            Number::make(__('Elevation'),'elevation'),

            BelongsTo::make(__('Member'),'Member')->searchable()->rules('required'),
            BelongsToMany::make(__('External Databases'),'ExternalDatabases')->hideFromIndex(),
            BelongsToMany::make(__('Climbing Styles'),'ClimbingStyles')->hideFromIndex(),
            BelongsToMany::make(__('Climbing Rock Types'),'ClimbingRockTypes')->hideFromIndex(),

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
