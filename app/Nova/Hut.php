<?php

namespace App\Nova;

use App\Nova\Actions\DownloadExcelAction;
use App\Nova\Filters\ElectricHeatingEnergySourceFilter;
use App\Nova\Filters\HutsManagedFilter;
use App\Nova\Filters\KitchenFacilityFilter;
use Wm\MapPoint\MapPoint;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\URL;
use App\Nova\Filters\Members;
use App\Nova\Filters\SanitaryFacilityFilter;
use App\Nova\Filters\WasteWaterTreatmentFilter;
use App\Nova\Filters\WaterSupplyFilter;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Http\Requests\NovaRequest;
use Kongulov\NovaTabTranslatable\NovaTabTranslatable;
use Rosamarsky\RangeFilter\RangeFilter;

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
        'id', 'official_name', 'member.acronym'
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
            Text::make(__('Official Name'), 'official_name')->sortable(),
            Text::make(__('Second Official Name'), 'second_official_name')->hideFromIndex(),
            Textarea::make(__('Description'), 'description')->sortable()->hideFromIndex(),
            MapPoint::make('geometry')->withMeta([
                'center' => ["51", "4"],
                'attribution' => '<a href="https://webmapp.it/">Webmapp</a> contributors',
                'tiles' => 'https://api.webmapp.it/tiles/{z}/{x}/{y}.png',
                'minZoom' => 5,
                'maxZoom' => 14,
                'defaultZoom' => 5
            ])->hideFromIndex(),
            Number::make(__('Elevation'), 'elevation')->rules('required')->hideFromIndex(),
            Text::make(__('URL'), 'url', function () {
                $urls = explode(',', $this->url);
                $html = '';
                foreach ($urls as $url) {
                    if (!empty($url)) {
                        if (strpos($url, 'http') === false) {
                            $url = 'https://' . $url;
                        }
                        $html .= '<a class="link-default" target="_blank" href="' . $url . '">' . $url . '</a></br>';
                    }
                }
                return $html;
            })->onlyOnDetail()->asHtml(),
            Text::make(__('URL'), 'url')->onlyOnForms(),
            // TODO: Relation Featured Image
            Boolean::make(__('Managed'), 'managed'),
            Text::make(__('Address'), 'address')
                ->hideFromIndex(),
            Text::make(__('Operating name'), 'operating_name')
                ->hideFromIndex(),
            Text::make(__('Operating email'), 'operating_email')
                ->hideFromIndex(),
            Text::make(__('Operating phone'), 'operating_phone')
                ->hideFromIndex(),
            Text::make(__('Owner'), 'owner')
                ->hideFromIndex(),
            BelongsTo::make(__('Member'), 'Member')
                ->searchable()
                ->rules('required'),
            Boolean::make('Wastewater Treatment')
                ->hideFromIndex()
                ->nullable(),
            Text::make('Waste Management System')
                ->nullable()
                ->hideFromIndex(),
            Boolean::make('Water Supply')
                ->nullable()
                ->hideFromIndex(),
            Boolean::make('Electric and Heating Energy Source')
                ->nullable()
                ->hideFromIndex(),
            Text::make('Area Type')
                ->help('national park or other protected area')
                ->nullable()
                ->hideFromIndex(),
            Boolean::make('Sanitary Facility')
                ->nullable()
                ->hideFromIndex(),
            Boolean::make('Kitchen Facility')
                ->nullable()
                ->hideFromIndex(),
            BelongsToMany::make(__('External Databases'), 'ExternalDatabases'),
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
        $adminFilters = [
            new Members(),
            new HutsManagedFilter,
            RangeFilter::make(
                'elevation',
                'elevation',
                [
                    'min' => 0,
                    'max' => 5000,
                    'interval' => 100,
                    'clickable' => true,
                    'tooltip' => 'hover'
                ]
            ),
            new WasteWaterTreatmentFilter,
            new WaterSupplyFilter,
            new ElectricHeatingEnergySourceFilter,
            new SanitaryFacilityFilter,
            new KitchenFacilityFilter,
        ];
        $userFilters = [
            RangeFilter::make(
                'elevation',
                'elevation',
                [
                    'min' => 0,
                    'max' => 5000,
                    'interval' => 100,
                    'clickable' => true,
                    'tooltip' => 'hover'
                ]
            ),
            new HutsManagedFilter,
            new WasteWaterTreatmentFilter,
            new WaterSupplyFilter,
            new ElectricHeatingEnergySourceFilter,
            new SanitaryFacilityFilter,
            new KitchenFacilityFilter,
        ];
        if ($request->user()->is_admin == true) {
            return $adminFilters;
        }
        return $userFilters;
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
        return [
            (new DownloadExcelAction)->canRun(function ($request) {
                return true;
            })
        ];
    }
}
