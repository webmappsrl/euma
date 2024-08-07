<?php

namespace App\Nova;

use Eminiarts\Tabs\Tab;
use Eminiarts\Tabs\Tabs;
use Laravel\Nova\Resource;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use App\Enums\TrailUserTypes;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\MultiSelect;
use App\Enums\MaintenanceOperatorTypes;
use Laravel\Nova\Http\Requests\NovaRequest;

class TrailSurvey extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\TrailSurvey>
     */
    public static $model = \App\Models\TrailSurvey::class;

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
        'id', 'member.name_en'
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
            BelongsTo::make('Member')->searchable(),
            Tabs::make('Trail Survey', [
                Tab::make('Member Info', [
                    Textarea::make(__('Responsible for Trails Comments'), 'responsible_for_trails_comments')
                        ->hideFromIndex()
                        ->nullable(),
                    Boolean::make('New Paths Agreement')
                        ->nullable()
                        ->hideFromIndex(),
                    TextArea::make('New Paths Agreement Comments')
                        ->nullable()
                        ->hideFromIndex(),
                    Boolean::make('Liability Exempted')
                        ->nullable()
                        ->hideFromIndex(),
                    TextArea::make('Liability Exempted Comments')
                        ->nullable()
                        ->hideFromIndex(),
                ]),
                Tab::make('Trails Info', [
                    Number::make(__('Trail Length (km)'), 'trail_length_km')
                        ->hideFromIndex()
                        ->nullable()
                        ->step('any')
                        ->displayUsing(function ($value) {
                            return $value . ' km';
                        }),
                    Number::make('Trail Network Area', 'trail_network_area')
                        ->nullable()
                        ->hideFromIndex()
                        ->step('any')
                        ->displayUsing(function ($value) {
                            return $value . ' km²';
                        }),
                    Text::make('Trail Network Location Country', 'trail_network_location_country')
                        ->nullable()
                        ->hideFromIndex(),
                    Text::make('Trail Network Location State', 'trail_network_location_state')
                        ->nullable()
                        ->hideFromIndex(),
                    Text::make('Trail Network Location Region', 'trail_network_location_region')
                        ->nullable()
                        ->hideFromIndex(),
                    Number::make('Trails mountain area percentage', 'trails_area_mountains_percentage')
                        ->nullable()
                        ->hideFromIndex()
                        ->max(100)
                        ->step('any')
                        ->displayUsing(function ($value) {
                            return $value . ' %';
                        }),
                    Number::make('Trails low mountain area percentage', 'trails_area_low_mountain_percentage')
                        ->nullable()
                        ->hideFromIndex()
                        ->max(100)
                        ->step('any')
                        ->displayUsing(function ($value) {
                            return $value . ' %';
                        }),
                    Number::make('Trails lowland percentage', 'trails_area_lowland_percentage')
                        ->nullable()
                        ->hideFromIndex()
                        ->max(100)
                        ->step('any')
                        ->displayUsing(function ($value) {
                            return $value . ' %';
                        }),
                    Boolean::make('Trails on Sealed Roads')
                        ->nullable()
                        ->hideFromIndex(),
                    Number::make('Trails on Sealed Roads Percentage', 'trails_on_sealed_roads_percentage')
                        ->nullable()
                        ->hideFromIndex()
                        ->max(100)
                        ->step('any')
                        ->displayUsing(function ($value) {
                            return $value . ' %';
                        }),
                    Boolean::make('Via Ferratas in Network')
                        ->nullable()
                        ->hideFromIndex(),
                    Number::make('Via Ferratas count', 'via_ferratas_count')
                        ->nullable()
                        ->hideFromIndex(),
                    Textarea::make('Via Ferratas Managing Description')
                        ->nullable()
                        ->hideFromIndex(),
                    Boolean::make('Trails Aligned with Legislation')
                        ->nullable()
                        ->hideFromIndex(),
                    TextArea::make('Trails Aligned with Legislation Comments')
                        ->nullable()
                        ->hideFromIndex(),
                    Boolean::make('Trails Constructed and Maintained by National Park, Local Communities or State organization', 'trails_constructed_and_maintained_by_np_lc_so')
                        ->nullable()
                        ->hideFromIndex(),
                    Number::make('Trails Constructed by National Parks Percentage', 'trails_constructed_by_national_parks_percentage')
                        ->nullable()
                        ->hideFromIndex()
                        ->max(100)
                        ->step('any')
                        ->displayUsing(function ($value) {
                            return $value . ' %';
                        }),
                    Number::make('Trails Constructed by Local Communities Percentage', 'trails_constructed_by_local_communities_percentage')
                        ->nullable()
                        ->hideFromIndex()
                        ->max(100)
                        ->step('any')
                        ->displayUsing(function ($value) {
                            return $value . ' %';
                        }),
                    Number::make('Trails Constructed by State Organisation Percentage', 'trails_constructed_by_state_organisation_percentage')
                        ->nullable()
                        ->hideFromIndex()
                        ->max(100)
                        ->step('any')
                        ->displayUsing(function ($value) {
                            return $value . ' %';
                        }),
                    Number::make('Trails Maintained by National Parks Percentage', 'trails_maintained_themself_by_national_parks_percentage')
                        ->nullable()
                        ->hideFromIndex()
                        ->max(100)
                        ->step('any')
                        ->displayUsing(function ($value) {
                            return $value . ' %';
                        }),
                    Number::make('Trails Maintained by Local Communities Percentage', 'trails_maintained_themself_by_local_communities_percentage')
                        ->nullable()
                        ->hideFromIndex()
                        ->max(100)
                        ->step('any')
                        ->displayUsing(function ($value) {
                            return $value . ' %';
                        }),
                    Number::make('Trails Maintained by State Organisation Percentage', 'trails_maintained_themself_by_state_organisation_percentage')
                        ->nullable()
                        ->hideFromIndex()
                        ->max(100)
                        ->step('any')
                        ->displayUsing(function ($value) {
                            return $value . ' %';
                        }),
                    Number::make('Trails Maintained MO by National Parks Percentage', 'trails_maintained_mo_by_national_parks_percentage')
                        ->nullable()
                        ->hideFromIndex()
                        ->max(100)
                        ->step('any')
                        ->displayUsing(function ($value) {
                            return $value . ' %';
                        }),
                    Number::make('Trails Maintained MO by Local Communities Percentage', 'trails_maintained_mo_by_local_communities_percentage')
                        ->nullable()
                        ->hideFromIndex()
                        ->max(100)
                        ->step('any')
                        ->displayUsing(function ($value) {
                            return $value . ' %';
                        }),
                    Number::make('Trails Maintained MO by State Organisation Percentage', 'trails_maintained_mo_by_state_organisation_percentage')
                        ->nullable()
                        ->hideFromIndex()
                        ->max(100)
                        ->step('any')
                        ->displayUsing(function ($value) {
                            return $value . ' %';
                        }),
                    TextArea::make('Comments on construction and maintenance', 'trails_constructed_and_maintained_comments')
                        ->nullable()
                        ->hideFromIndex(),
                    Boolean::make('Trails Construction Maintained Frequently')
                        ->nullable()
                        ->hideFromIndex(),
                    Text::make('Average Trails Construction Maintenance Period')
                        ->nullable()
                        ->hideFromIndex(),
                    Boolean::make('Trails Physically Marked')
                        ->nullable()
                        ->hideFromIndex(),
                    Textarea::make('Trails Marking System Description')
                        ->nullable()
                        ->hideFromIndex(),
                    Boolean::make('Trails Signs Maintained Frequently')
                        ->nullable()
                        ->hideFromIndex(),
                    Number::make('Average Trails Signs Maintenance Period (in years)', 'average_trails_signs_maintenance_period')
                        ->nullable()
                        ->hideFromIndex()
                        ->step('any'),
                    Textarea::make('Trails Signs Maintenance Scope')
                        ->nullable()
                        ->hideFromIndex(),
                    MultiSelect::make('Trails maintenance operators', 'trails_maintenance_done_by')
                        ->options(collect(MaintenanceOperatorTypes::cases())->pluck('name', 'value'))
                        ->displayUsingLabels()
                        ->nullable()
                        ->hideFromIndex(),
                    Textarea::make('Trails Maintenance System Description')
                        ->nullable()
                        ->hideFromIndex(),
                    Number::make('Trails Percentage Maintenance Costs Covered by Public Funding')
                        ->nullable()
                        ->hideFromIndex()
                        ->max(100)
                        ->step('any'),
                    TextArea::make('Trails Maintenance Comments')
                        ->nullable()
                        ->hideFromIndex(),
                    Boolean::make('Trails Recognized by Government')
                        ->nullable()
                        ->hideFromIndex(),
                    Textarea::make('Trails Recognized by Government Comments')
                        ->nullable()
                        ->hideFromIndex(),
                    Boolean::make('Trails Sustainability')
                        ->nullable()
                        ->hideFromIndex(),
                    Textarea::make('Trails Sustainability Comments')
                        ->nullable()
                        ->hideFromIndex(),
                    Boolean::make('Digital Trails Database', 'has_digital_database')
                        ->nullable()
                        ->hideFromIndex(),
                    TextArea::make('Digital Database Description')
                        ->nullable()
                        ->hideFromIndex(),
                    Boolean::make('Hikers Have Free Access to Database')
                        ->nullable()
                        ->hideFromIndex(),
                    TextArea::make('Hikers Free Access to Database Description', 'hikers_free_access_db_description')
                        ->nullable()
                        ->hideFromIndex(),
                    TextArea::make('Trails Issues')
                        ->nullable()
                        ->hideFromIndex(),
                ]),
                Tab::make('Trails Accessibility', [
                    Boolean::make('Free Access to Trails')
                        ->nullable()
                        ->hideFromIndex(),
                    TextArea::make('Free Access to Trails Comments')
                        ->nullable()
                        ->hideFromIndex(),
                    Boolean::make('Trails for Hikers Only')
                        ->nullable()
                        ->hideFromIndex(),
                    MultiSelect::make('Trails Users', 'other_trails_users')
                        ->options(collect(TrailUserTypes::cases())->pluck('name', 'value'))
                        ->displayUsingLabels()
                        ->nullable()
                        ->hideFromIndex(),
                    TextArea::make('Other trails users comment', 'other_trails_users_comment')
                        ->nullable()
                        ->hideFromIndex(),
                    Boolean::make('Approach Trails to Climbing', 'approach_trails_to_climbing')
                        ->nullable()
                        ->hideFromIndex(),
                    Number::make('Approach Trails to Climbing Percentage', 'percentage_of_approach_trails_to_climbing')
                        ->nullable()
                        ->hideFromIndex()
                        ->max(100)
                        ->step('any')
                        ->displayUsing(function ($value) {
                            return $value . ' %';
                        }),
                    Boolean::make('Grading System Difficulty')
                        ->nullable()
                        ->hideFromIndex(),
                    Textarea::make('Difficulty Grading System Description')
                        ->nullable()
                        ->hideFromIndex(),
                    Boolean::make('Trails Grading System')
                        ->nullable()
                        ->hideFromIndex(),
                    Textarea::make('Trails Grading System Description')
                        ->nullable()
                        ->hideFromIndex(),
                    Boolean::make('Trails Clearly Visible')
                        ->nullable()
                        ->hideFromIndex(),
                    Textarea::make('Trails Clearly Visible Description')
                        ->nullable()
                        ->hideFromIndex(),
                    Boolean::make('Trails Allowed on Any Area')
                        ->nullable()
                        ->hideFromIndex(),
                    Textarea::make('Trails Allowed on Any Area Description')
                        ->nullable()
                        ->hideFromIndex(),
                    Boolean::make('Trails Keepers Specified')
                        ->nullable()
                        ->hideFromIndex(),
                    Textarea::make('Trails Keepers Specified Description')
                        ->nullable()
                        ->hideFromIndex(),

                ]),
                Tab::make('Costs', [
                    Currency::make('Mountain trails construction cost', 'mountain_trails_construction_cost', )
                        ->nullable()
                        ->hideFromIndex()
                        ->currency('EUR')
                        ->displayUsing(function ($value) {
                            return $value . ' €/km';
                        }),
                    Currency::make('Low Mountain trails construction cost', 'low_mountain_trails_construction_cost')
                        ->nullable()
                        ->hideFromIndex()
                        ->currency('EUR')
                        ->displayUsing(function ($value) {
                            return $value . ' €/km';
                        }),
                    Currency::make('Lowland trails construction cost by National Parks', 'lowland_trails_construction_cost')
                        ->nullable()
                        ->hideFromIndex()
                        ->currency('EUR')
                        ->displayUsing(function ($value) {
                            return $value . ' €/km';
                        }),

                    Currency::make('Mountain trails maintenance cost yearly', 'mountain_trails_maintenance_cost', )
                        ->nullable()
                        ->hideFromIndex()
                        ->currency('EUR')
                        ->displayUsing(function ($value) {
                            return $value . ' €/km';
                        }),
                    Currency::make('Low Mountain trails maintenance cost yearly', 'low_mountain_trails_maintenance_cost')
                        ->nullable()
                        ->hideFromIndex()
                        ->currency('EUR')
                        ->displayUsing(function ($value) {
                            return $value . ' €/km';
                        }),
                    Currency::make('Lowland trails maintenance cost yearly by National Parks', 'lowland_trails_maintenance_cost')
                        ->nullable()
                        ->hideFromIndex()
                        ->currency('EUR')
                        ->displayUsing(function ($value) {
                            return $value . ' €/km';
                        }),
                    Currency::make('Average Annual Sign Maintenance Cost for Mountains', 'average_annual_sign_maintenance_cost_for_mountains', )
                        ->nullable()
                        ->hideFromIndex()
                        ->currency('EUR')
                        ->displayUsing(function ($value) {
                            return $value . ' €/km';
                        }),
                    Currency::make('Average Annual Sign Maintenance Cost for Low Mountains', 'average_annual_sign_maintenance_cost_for_low_mountains')
                        ->nullable()
                        ->hideFromIndex()
                        ->currency('EUR')
                        ->displayUsing(function ($value) {
                            return $value . ' €/km';
                        }),
                    Currency::make('Average Annual Sign Maintenance Cost for Lowlands', 'average_annual_sign_maintenance_cost_for_lowlands')
                        ->nullable()
                        ->hideFromIndex()
                        ->currency('EUR')
                        ->displayUsing(function ($value) {
                            return $value . ' €/km';
                        }),
                ]),

            ])
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
