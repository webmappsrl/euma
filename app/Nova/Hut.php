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
use Laravel\Nova\Fields\Textarea;
use Wm\MapPoint\MapPoint;

class Hut extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Hut::class;

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
                Textarea::make(__('Description'), 'description')->sortable(),
            ]),
            // MapPoint::make('geometry')->withMeta([
            //     'center' => ["42", "10"],
            //     'attribution' => '<a href="https://webmapp.it/">Webmapp</a> contributors',
            //     'tiles' => 'https://api.webmapp.it/tiles/{z}/{x}/{y}.png'
            // ]),
            Code::make(__('Geobox location'), 'geobox_location'),
            Number::make(__('Elevation'),'elevation'),
            Number::make(__('Geobox elevation'),'geobox_elevation'),
            Text::make(__('URL'), 'url'),
            // TODO: Relation Featured Image
            Boolean::make(__('Managed'),'managed'),
            Text::make(__('Address'),'address'),
            Text::make(__('Operating name'),'operating_name'),
            Text::make(__('Operating email'),'operating_email'),
            Text::make(__('Operating phone'),'operating_phone'),
            Text::make(__('Owner'),'owner'),

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
