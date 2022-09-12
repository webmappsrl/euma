<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Kongulov\NovaTabTranslatable\NovaTabTranslatable;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Textarea;
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
                Text::make(__('Name'), 'name')->sortable()->rules('required'),
                Textarea::make(__('Description'), 'description'),
                Text::make(__('Alternative name'), 'alternative_name')->rules('required'),
            ]),

            // MapPoint::make('geometry')->withMeta([
            //     'center' => ["42", "10"],
            //     'attribution' => '<a href="https://webmapp.it/">Webmapp</a> contributors',
            //     'tiles' => 'https://api.webmapp.it/tiles/{z}/{x}/{y}.png'
            // ]),

            Text::make(__('Local rules url'),'local_rules_url')->rules('required'),
            Textarea::make(__('Local rules description'), 'local_rules_description'),
            // TODO: local_rules_document upload file

            Boolean::make(__('Local restricions'),'local_restricions'),
            Textarea::make(__('Local restrictions desctription'), 'local_restrictions_desctription')->sortable(),

            // TODO: parking_position MapPoint

            Select::make(__('Location quality'), 'location_quality')->hideFromIndex()->options([
                1 => 'Good routes, but a bad area a quarry',
                2 => 'A good location, and good climbing moves',
                3 => 'An exceptional location with memorable routes'
            ])->displayUsingLabels(),

            Number::make(__('Routes number'),'routes_number'),
            Text::make(__('Nearest town'), 'nearest_town'),
            Number::make(__('Elevation'),'elevation'),
            Number::make(__('Geobox elevation'),'geobox_elevation')->rules('required'),
            Code::make(__('Geobox location'), 'geobox_location')->rules('required'),
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
