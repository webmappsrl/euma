<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Kongulov\NovaTabTranslatable\NovaTabTranslatable;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\URL;
use Laravel\Nova\Http\Requests\NovaRequest;
use Wm\MapMultiLinestring\MapMultiLinestring;

class Trail extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Trail::class;

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
        'id','name','ref'
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
            ]),
            Text::make(__('REF'), 'ref'),
            Text::make(__('URL'), 'url', function () {
                $urls = explode(',',$this->url);
                $html = '';
                foreach ($urls as $url) {
                    if (strpos($url,'http') === false){
                        $url = 'https://'.$url;
                    }
                    $html .= '<a class="link-default" target="_blank" href="' . $url . '">' . $url . '</a></br>';
                }
                return $html;
            })->onlyOnDetail()->asHtml(),
            Text::make(__('URL'), 'url')->onlyOnForms(),  
            URL::make(__('Source geojson url'), 'source_geojson_url')->displayUsing(fn () => "$this->source_geojson_url")->hideFromIndex(),
            URL::make(__('Source gpx url'), 'source_gpx_url')->displayUsing(fn () => "$this->source_gpx_url")->hideFromIndex(),
            MapMultiLinestring::make('geometry')->withMeta([
                'center' => ["43", "10"],
                'attribution' => '<a href="https://webmapp.it/">Webmapp</a> contributors',
                'tiles' => 'https://api.webmapp.it/tiles/{z}/{x}/{y}.png',
                'defaultZoom' => 10
            ]),
            BelongsTo::make(__('Member'),'Member')->searchable()->rules('required'),
            BelongsToMany::make(__('External Databases'),'ExternalDatabases')->hideFromIndex(),
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
