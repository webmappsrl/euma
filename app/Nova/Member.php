<?php

namespace App\Nova;

use App\Enums\MaintenanceOperatorTypes;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\URL;
use App\Enums\MemberTypeEnum;
use App\Enums\TrailNetworkLocation;
use App\Enums\TrailUserTypes;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use App\Nova\Filters\MemberType;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\MultiSelect;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class Member extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Member::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name_en';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name_en', 'acronym'
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
            Text::make(__('Name en'), 'name_en')
                ->rules('required'),
            Text::make(__('Name Orig'), 'name_orig')
                ->rules('required')
                ->hideFromIndex(),
            Text::make(__('Acronym'), 'acronym')
                ->rules('required'),
            Text::make(__('Country'), 'country')
                ->rules('required'),
            URL::make(__('Web'), 'web')
                ->displayUsing(fn () => "$this->web")
                ->hideFromIndex(),
            Number::make(__('Members'), 'members'),
            Number::make(__('Since'), 'since')
                ->rules('required'),
            Select::make(__('Type'), 'type')
                ->hideFromIndex()->options(MemberTypeEnum::getValueNames())
                ->displayUsingLabels()
                ->rules('required'),
            Image::make(__('Icon'), 'icon')
                ->disk('public')
                ->path('/member/' . $this->model()->id . '/resources')
                ->storeAs(function () {
                    return 'icon.png';
                })
                ->hideFromIndex(),
            Text::make(__('Contact Name'), 'contact_name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make(__('Contact Role'), 'contact_role')
                ->hideFromIndex()
                ->nullable()
                ->rules('max:255'),

            Text::make(__('Contact Email'), 'contact_email')
                ->hideFromIndex()
                ->nullable()
                ->rules('email', 'max:255'),

            Text::make(__('Contact Phone'), 'contact_phone')
                ->hideFromIndex()
                ->nullable()
                ->rules('max:255'),

            DateTime::make(__('Contact Completion Date'), 'contact_completion_date')
                ->hideFromIndex()
                ->nullable(),


            Boolean::make(__('Responsible for Trails'), 'responsible_for_trails')
                ->hideFromIndex()
                ->nullable(),

            Textarea::make(__('Responsible for Trails Comments'), 'responsible_for_trails_comments')
                ->hideFromIndex()
                ->nullable(),

            Number::make(__('Trail Length (km)'), 'trail_length_km')
                ->hideFromIndex()
                ->nullable()
                ->step(0.1)
                ->displayUsing(function ($value) {
                    return $value . ' km';
                }),
            Number::make('Trail Network Area', 'trail_network_area')
                ->nullable()
                ->displayUsing(function ($value) {
                    return $value . ' km²';
                }),
            Select::make('Trail Network Location', 'trail_network_location')
                ->options(collect(TrailNetworkLocation::cases())->pluck('name', 'value'))
                ->displayUsingLabels()
                ->nullable(),
            Number::make('Trails mountain area percentage', 'trails_area_mountains_percentage')
                ->nullable()
                ->displayUsing(function ($value) {
                    return $value . ' %';
                }),
            Number::make('Trails low mountain area percentage', 'trails_area_low_mountain_percentage')
                ->nullable()
                ->max(100)
                ->displayUsing(function ($value) {
                    return $value . ' %';
                }),
            Number::make('Trails lowland percentage', 'trails_area_lowland_percentage')
                ->nullable()
                ->max(100)
                ->displayUsing(function ($value) {
                    return $value . ' %';
                }),
            Boolean::make('Trails on Sealed Roads')
                ->nullable(),
            Number::make('Trails on Sealed Roads Percentage', 'trails_on_sealed_roads_percentage')
                ->nullable()
                ->max(100)
                ->displayUsing(function ($value) {
                    return $value . ' %';
                }),
            Boolean::make('Via Ferratas in Network')
                ->nullable(),
            Number::make('Via Ferratas count', 'via_ferratas_count')
                ->nullable(),
            Text::make('Via Ferratas Managing Description')
                ->nullable(),
            Boolean::make('Free Access to Trails')
                ->nullable(),
            TextArea::make('Free Access to Trails Comments')
                ->nullable(),
            Boolean::make('Trails Aligned with Legislation')
                ->nullable(),
            TextArea::make('Trails Aligned with Legislation Comments')
                ->nullable(),
            Boolean::make('Trails for Hikers Only')
                ->nullable(),
            MultiSelect::make('Trails Users', 'other_trails_users')
                ->options(collect(TrailUserTypes::cases())->pluck('name', 'value'))
                ->displayUsingLabels()
                ->nullable(),
            Boolean::make('Trails Constructed and Maintained by National Park, Local Communities or State organization', 'trails_constructed_and_maintained_by_np_lc_so')
                ->nullable(),
            Number::make('Trails Constructed by National Parks Percentage', 'trails_constructed_by_national_parks_percentage')
                ->nullable()
                ->max(100)
                ->displayUsing(function ($value) {
                    return $value . ' %';
                }),
            Number::make('Trails Constructed by Local Communities Percentage', 'trails_constructed_by_local_communities_percentage')
                ->nullable()
                ->max(100)
                ->displayUsing(function ($value) {
                    return $value . ' %';
                }),
            Number::make('Trails Constructed by State Organisation Percentage', 'trails_constructed_by_state_organisation_percentage')
                ->nullable()
                ->max(100)
                ->displayUsing(function ($value) {
                    return $value . ' %';
                }),
            Number::make('Trails Maintained by National Parks Percentage', 'trails_maintained_themself_by_national_parks_percentage')
                ->nullable()
                ->max(100)
                ->displayUsing(function ($value) {
                    return $value . ' %';
                }),
            Number::make('Trails Maintained by Local Communities Percentage', 'trails_maintained_themself_by_local_communities_percentage')
                ->nullable()
                ->max(100)
                ->displayUsing(function ($value) {
                    return $value . ' %';
                }),
            Number::make('Trails Maintained by State Organisation Percentage', 'trails_maintained_themself_by_state_organisation_percentage')
                ->nullable()
                ->max(100)
                ->displayUsing(function ($value) {
                    return $value . ' %';
                }),
            Number::make('Trails Maintained MO by National Parks Percentage', 'trails_maintained_mo_by_national_parks_percentage')
                ->nullable()
                ->max(100)
                ->displayUsing(function ($value) {
                    return $value . ' %';
                }),
            Number::make('Trails Maintained MO by Local Communities Percentage', 'trails_maintained_mo_by_local_communities_percentage')
                ->nullable()
                ->max(100)
                ->displayUsing(function ($value) {
                    return $value . ' %';
                }),
            Number::make('Trails Maintained MO by State Organisation Percentage', 'trails_maintained_mo_by_state_organisation_percentage')
                ->nullable()
                ->max(100)
                ->displayUsing(function ($value) {
                    return $value . ' %';
                }),
            TextArea::make('Comments on construction and maintenance', 'trails_constructed_and_maintained_comments')
                ->nullable(),
            Boolean::make('Approach Trails to Climbing', 'approach_trails_to_climbing')->nullable(),
            Number::make('Approach Trails to Climbing Percentage', 'percentage_of_approach_trails_to_climbing')
                ->nullable()
                ->max(100)
                ->displayUsing(function ($value) {
                    return $value . ' %';
                }),
            Boolean::make('Grading System Difficulty')
                ->nullable(),
            Text::make('Difficulty Grading System Description')
                ->nullable(),
            Boolean::make('Trails Grading System')
                ->nullable(),
            Text::make('Trails Grading System Description')
                ->nullable(),
            Boolean::make('Trails Clearly Visible')->nullable(),
            Text::make('Trails Clearly Visible Description')->nullable(),
            Boolean::make('Trails Allowed on Any Area')->nullable(),
            Text::make('Trails Allowed on Any Area Description')->nullable(),
            Boolean::make('Trails Keepers Specified')->nullable(),
            Text::make('Trails Keepers Specified Description')->nullable(),
            Currency::make('Mountain trails construction cost (€/km)', 'mountain_trails_construction_cost',)
                ->nullable()
                ->currency('EUR')
                ->displayUsing(function ($value) {
                    return $value . ' €/km';
                }),
            Currency::make('Low Mountain trails construction cost (€/km)', 'low_mountain_trails_construction_cost')
                ->nullable()
                ->currency('EUR')
                ->displayUsing(function ($value) {
                    return $value . ' €/km';
                }),
            Currency::make('Lowland trails construction cost (€/km) by National Parks', 'lowland_trails_construction_cost')
                ->nullable()
                ->currency('EUR')
                ->displayUsing(function ($value) {
                    return $value . ' €/km';
                }),
            Boolean::make('Trails Construction Maintained Frequently')->nullable(),
            Text::make('Average Trails Construction Maintenance Period')->nullable(),
            Currency::make('Mountain trails maintenance cost yearly (€/km)', 'mountain_trails_maintenance_cost',)
                ->nullable()
                ->currency('EUR')
                ->displayUsing(function ($value) {
                    return $value . ' €/km';
                }),
            Currency::make('Low Mountain trails maintenance cost yearly (€/km)', 'low_mountain_trails_maintenance_cost')
                ->nullable()
                ->currency('EUR')
                ->displayUsing(function ($value) {
                    return $value . ' €/km';
                }),
            Currency::make('Lowland trails maintenance cost yearly (€/km) by National Parks', 'lowland_trails_maintenance_cost')
                ->nullable()
                ->currency('EUR')
                ->displayUsing(function ($value) {
                    return $value . ' €/km';
                }),
            Boolean::make('Trails Physically Marked')
                ->nullable(),
            Text::make('Trails Marking System Description')
                ->nullable(),
            Boolean::make('Trails Signs Maintained Frequently')
                ->nullable(),
            Number::make('Average Trails Signs Maintenance Period (in years)', 'average_trails_signs_maintenance_period')
                ->nullable()
                ->step('any'),
            Text::make('Trails Signs Maintenance Scope')
                ->nullable(),
            Currency::make('Average Annual Sign Maintenance Cost for Mountains (€/km)', 'average_annual_sign_maintenance_cost_for_mountains',)
                ->nullable()
                ->currency('EUR')
                ->displayUsing(function ($value) {
                    return $value . ' €/km';
                }),
            Currency::make('Average Annual Sign Maintenance Cost for Low Mountains (€/km)', 'average_annual_sign_maintenance_cost_for_low_mountains')
                ->nullable()
                ->currency('EUR')
                ->displayUsing(function ($value) {
                    return $value . ' €/km';
                }),
            Currency::make('Average Annual Sign Maintenance Cost for Lowlands (€/km)', 'average_annual_sign_maintenance_cost_for_lowlands')
                ->nullable()
                ->currency('EUR')
                ->displayUsing(function ($value) {
                    return $value . ' €/km';
                }),
            MultiSelect::make('Trails maintenance operators', 'trails_maintenance_done_by')
                ->options(collect(MaintenanceOperatorTypes::cases())->pluck('name', 'value'))
                ->displayUsingLabels()
                ->nullable(),
            Text::make('Trails Maintenance System Description')
                ->nullable(),
            Number::make('Trails Percentage Maintenance Costs Covered by Public Funding')
                ->nullable()
                ->step('any'),
            TextArea::make('Trails Maintenance Comments')->nullable(),
            Boolean::make('Trails Recognized by Government')->nullable(),
            Text::make('Trails Recognized by Government Comments')->nullable(),
            Boolean::make('New Paths Agreement')->nullable(),
            TextArea::make('New Paths Agreement Comments')->nullable(),
            Boolean::make('Liability Exempted')->nullable(),
            TextArea::make('Liability Exempted Comments')->nullable(),
            Boolean::make('Trails Sustainability')->nullable(),
            Text::make('Trails Sustainability Comments')->nullable(),
            Boolean::make('Digital Trails Database', 'has_digital_database')->nullable(),
            TextArea::make('Digital Database Description')->nullable(),
            Boolean::make('Hikers Have Free Access to Database')->nullable(),
            TextArea::make('Trails Issues')->nullable()
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
                new MemberType
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