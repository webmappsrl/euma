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
use Laravel\Nova\Fields\URL;
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
    public static $title = 'official_name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id','official_name','member.acronym'
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
            Text::make(__('Official Name'), 'official_name')->sortable(),
            Text::make(__('Second Official Name'), 'second_official_name')->hideFromIndex(),
            Textarea::make(__('Description'), 'description')->sortable()->hideFromIndex(),
            MapPoint::make('geometry')->withMeta([
                'center' => ["51", "4"],
                'attribution' => '<a href="https://webmapp.it/">Webmapp</a> contributors',
                'tiles' => 'https://api.webmapp.it/tiles/{z}/{x}/{y}.png',
                'minZoom' => 5,
                'maxZoom' => 16,
                'defaultZoom' => 5
            ]),
            Number::make(__('Elevation'),'elevation')->rules('required')->hideFromIndex(),
            Text::make(__('URL'), 'url', function () {
                $urls = explode(',',$this->url);
                $html = '';
                foreach ($urls as $url) {
                    if (!empty($url)) {
                        if (strpos($url,'http') === false){
                            $url = 'https://'.$url;
                        }
                        $html .= '<a class="link-default" target="_blank" href="' . $url . '">' . $url . '</a></br>';
                    }
                }
                return $html;
            })->onlyOnDetail()->asHtml(),
            Text::make(__('URL'), 'url')->onlyOnForms(),
            // TODO: Relation Featured Image
            Boolean::make(__('Managed'),'managed'),
            Text::make(__('Address'),'address')->hideFromIndex(),
            Text::make(__('Operating name'),'operating_name')->hideFromIndex(),
            Text::make(__('Operating email'),'operating_email')->hideFromIndex(),
            Text::make(__('Operating phone'),'operating_phone')->hideFromIndex(),
            Text::make(__('Owner'),'owner')->hideFromIndex(),
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
