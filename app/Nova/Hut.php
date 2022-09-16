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
                Textarea::make(__('Description'), 'description')->sortable()->hideFromIndex(),
            ]),
            MapPoint::make('geometry')->withMeta([
                'center' => ["51", "4"],
                'attribution' => '<a href="https://webmapp.it/">Webmapp</a> contributors',
                'tiles' => 'https://api.webmapp.it/tiles/{z}/{x}/{y}.png'
            ])->rules('required'),
            Number::make(__('Elevation'),'elevation')->rules('required'),
            Text::make(__('URL'), 'url')->hideFromIndex(),
            // TODO: Relation Featured Image
            Boolean::make(__('Managed'),'managed'),
            Text::make(__('Address'),'address')->hideFromIndex(),
            Text::make(__('Operating name'),'operating_name')->hideFromIndex(),
            Text::make(__('Operating email'),'operating_email')->hideFromIndex(),
            Text::make(__('Operating phone'),'operating_phone')->hideFromIndex(),
            Text::make(__('Owner'),'owner'),
            BelongsTo::make(__('Member'),'Member')->searchable()->rules('required'),
            BelongsToMany::make(__('External Databases'),'ExternalDatabases'),
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
