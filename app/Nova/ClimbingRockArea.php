<?php

namespace App\Nova;

use App\Nova\Filters\Members;
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
    public static $title = 'original_name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id','member.acronym','original_name','english_name'
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
        } elseif ($request->user()->member) {
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
            Text::make(__('Original Name'), 'original_name')->rules('required_if:english_name,null')->sortable(),
            Text::make(__('English Name'), 'english_name')->sortable()->hideFromIndex(),
            Textarea::make(__('English Description'), 'english_description')->hideFromIndex(),
            Textarea::make(__('Original Description'), 'original_description')->hideFromIndex(),

            MapPoint::make('geometry')->withMeta([
                'center' => ["42", "10"],
                'attribution' => '<a href="https://webmapp.it/">Webmapp</a> contributors',
                'tiles' => 'https://api.webmapp.it/tiles/{z}/{x}/{y}.png',
                'minZoom' => 5,
                'maxZoom' => 16,
                'defaultZoom' => 5
            ])->hideFromIndex(),
            Text::make(__('URL'), 'url', function () {
                $urls = explode(',', $this->url);
                $html = '';
                foreach ($urls as $url) {
                    if ($url && strpos($url, 'http') === false) {
                        $url = 'https://'.$url;
                    }
                    $html .= '<a class="link-default" target="_blank" href="' . $url . '">' . $url . '</a></br>';
                }
                return $html;
            })->onlyOnDetail()->asHtml(),
            Text::make(__('URL'), 'url')->onlyOnForms(),
            URL::make(__('Local rules url'), 'local_rules_url')->displayUsing(fn () => "$this->local_rules_url")->hideFromIndex(),
            Textarea::make(__('English local rules description'), 'english_local_rules_description')->hideFromIndex(),
            Textarea::make(__('Original local rules description'), 'original_local_rules_description')->hideFromIndex(),

            // TODO: local_rules_document upload file

            Boolean::make(__('Local restrictions'), 'local_restrictions')->hideFromIndex(),
            Textarea::make(__('English local restrictions description'), 'english_local_restrictions_description')->hideFromIndex(),
            Textarea::make(__('Original local restrictions description'), 'original_local_restrictions_description')->hideFromIndex(),

            MapPoint::make(__('Parking position'), 'parking_position')->withMeta([
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

            Number::make(__('Routes number'), 'routes_number'),
            Number::make(__('Elevation'), 'elevation'),

            BelongsTo::make(__('Member'), 'Member')->searchable()->rules('required'),
            BelongsToMany::make(__('External Databases'), 'ExternalDatabases')->fields(function ($request, $relatedModel) {
                return [
                    Text::make(__('Specific URL'), 'specific_url'),
                ];
            })->hideFromIndex(),
            BelongsToMany::make(__('Climbing Styles'), 'ClimbingStyles')->hideFromIndex(),
            BelongsToMany::make(__('Climbing Rock Types'), 'ClimbingRockTypes')->hideFromIndex(),

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
        if ($request->user()->is_admin == true) {
            return [
                new Members()
            ];
        }
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
