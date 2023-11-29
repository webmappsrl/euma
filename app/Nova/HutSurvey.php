<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Http\Requests\NovaRequest;
use Eminiarts\Tabs\Tabs;
use Eminiarts\Tabs\Tab;

class HutSurvey extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\HutSurvey>
     */
    public static $model = \App\Models\HutSurvey::class;

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
        'id', 'member.name'
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
            new Tabs('Hut Survey', [
                new Tab('General Info', $this->generalInfoFields()),
                new Tab('Waste Water Treatment', $this->wasteWaterTreatmentFields()),
                new Tab('Waste Management', $this->wasteManagementFields()),
                new Tab('Water Supply', $this->waterSupplyFields()),
                new Tab('Source of Energy', $this->sourceOfEnergyFields()),
                new Tab('National Park', $this->nationalParkFields()),
                new Tab('Sanitary', $this->sanitaryFields()),
                new Tab('Kitchen', $this->kitchenFields()),
                new Tab('Hut Type', $this->hutTypeFields()),
                new Tab('Ownership', $this->ownershipFields()),
            ]),
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


    //general info fields
    public function generalInfoFields()
    {
        return [
            ID::make()->sortable(),
            BelongsTo::make('Member')->searchable(),
        ];
    }

    //waste water treatment fields
    public function wasteWaterTreatmentFields()
    {
        return [
            Number::make('Mechanical + Biological Wastewater Treatment', 'wastewater_mechanical_plus_biological_treatment')->nullable(),
            Number::make('Mechanical + Biological Wastewater Treatment Percentage', 'wastewater_mechanical_plus_biological_treatment_percentage')->nullable(),
            Number::make('No Wastewater Treatment', 'wastewater_no_treatment')->nullable(),
            Number::make('No Wastewater Treatment Percentage', 'wastewater_no_treatment_percentage')->nullable(),
            Number::make('Public Grid Wastewater', 'wastewater_public_grid')->nullable(),
            Number::make('Public Grid Wastewater Percentage', 'wastewater_public_grid_percentage')->nullable(),
            Number::make('Unspecified Wastewater', 'wastewater_unspecified')->nullable(),
            Number::make('Unspecified Wastewater Percentage', 'wastewater_unspecified_percentage')->nullable(),
            Number::make('Wastewater Treatment Grand Total', 'wastewater_treatment_grand_total')->nullable(),
        ];
    }

    //waste management fields
    public function wasteManagementFields()
    {
        return [
            Number::make('Waste Management System Yes', 'waste_management_system_yes')->nullable(),
            Number::make('Waste Management System Yes Percentage', 'waste_management_system_yes_percentage')->nullable(),
            Number::make('Waste Management System No', 'waste_management_system_no')->nullable(),
            Number::make('Waste Management System No Percentage', 'waste_management_system_no_percentage')->nullable(),
            Number::make('Waste Management System Grand Total', 'waste_management_system_grand_total')->nullable(),
        ];
    }

    //water supply fields
    public function waterSupplyFields()
    {
        return [
            Number::make('Surface Water Supply', 'surface_water_supply')->nullable(),
            Number::make('Surface Water Supply Percentage', 'surface_water_supply_percentage')->nullable(),
            Number::make('Ground Well Water Supply', 'ground_well_water_supply')->nullable(),
            Number::make('Ground Well Water Supply Percentage', 'ground_well_water_supply_percentage')->nullable(),
            Number::make('Public Supply', 'public_supply')->nullable(),
            Number::make('Public Supply Percentage', 'public_supply_percentage')->nullable(),
            Number::make('No Water Supply', 'no_water_supply')->nullable(),
            Number::make('No Water Supply Percentage', 'no_water_supply_percentage')->nullable(),
            Number::make('Water Supply Grand Total', 'water_supply_grand_total')->nullable(),
        ];
    }

    //source of energy fields
    public function sourceOfEnergyFields()
    {
        return [
            Number::make('Public Grid Energy Source', 'source_of_energy_public_grid')->nullable(),
            Number::make('Public Grid Energy Source Percentage', 'source_of_energy_public_grid_percentage')->nullable(),
            Number::make('Renewable Energy Source', 'source_of_energy_renewable')->nullable(),
            Number::make('Renewable Energy Source Percentage', 'source_of_energy_renewable_percentage')->nullable(),
            Number::make('Generator Energy Source', 'source_of_energy_generator')->nullable(),
            Number::make('Generator Energy Source Percentage', 'source_of_energy_generator_percentage')->nullable(),
            Number::make('No Energy Source', 'no_source_of_energy')->nullable(),
            Number::make('No Energy Source Percentage', 'no_source_of_energy_percentage')->nullable(),
            Number::make('Source of Energy Grand Total', 'source_of_energy_grand_total')->nullable(),
        ];
    }

    //national park fields
    public function nationalParkFields()
    {
        return [
            Number::make('National Parks', 'national_parks')->nullable(),
            Number::make('National Parks Percentage', 'national_parks_percentage')->nullable(),
            Number::make('Protected Areas', 'protected_areas')->nullable(),
            Number::make('Protected Areas Percentage', 'protected_areas_percentage')->nullable(),
            Number::make('No National Parks', 'no_national_parks')->nullable(),
            Number::make('No National Parks Percentage', 'no_national_parks_percentage')->nullable(),
            Number::make('National Parks Grand Total', 'national_parks_grand_total')->nullable(),
        ];
    }

    //sanitary fields
    public function sanitaryFields()
    {
        return [
            Number::make('Dry Toilets Sanitary', 'sanitary_dry_toilets')->nullable(),
            Number::make('Wet Toilets Sanitary', 'sanitary_wet_toilets')->nullable(),
            Number::make('Separation Toilets Sanitary', 'sanitary_toilets_separation')->nullable(),
            Number::make('Total Toilets Sanitary', 'sanitary_toilets')->nullable(),
            Number::make('Showers Sanitary', 'sanitary_showers')->nullable(),
            Number::make('Total With Toilets Sanitary', 'sanitary_total_with_toilets')->nullable(),
            Number::make('Total With Toilets Percentage Sanitary', 'sanitary_total_with_toilets_percentage')->nullable(),
            Number::make('Total Without Toilets Sanitary', 'sanitary_total_without_toilets')->nullable(),
            Number::make('Total Without Toilets Percentage Sanitary', 'sanitary_total_without_toilets_percentage')->nullable(),
        ];
    }

    //kitchen fields
    public function kitchenFields()
    {
        return [
            Number::make('Electric Kitchen', 'electric_kitchen')->nullable(),
            Number::make('Electric Kitchen Percentage', 'electric_kitchen_percentage')->nullable(),
            Number::make('Gas Kitchen', 'gas_kitchen')->nullable(),
            Number::make('Gas Kitchen Percentage', 'gas_kitchen_percentage')->nullable(),
            Number::make('Wood Kitchen', 'wood_kitchen')->nullable(),
            Number::make('Wood Kitchen Percentage', 'wood_kitchen_percentage')->nullable(),
            Number::make('No Kitchen', 'no_kitchen')->nullable(),
            Number::make('No Kitchen Percentage', 'no_kitchen_percentage')->nullable(),
            Number::make('Kitchen Grand Total', 'kitchen_grand_total')->nullable(),
        ];
    }

    //hut type fields
    public function hutTypeFields()
    {
        return [
            Number::make('Hut Type Hut', 'hut_type_hut')->nullable(),
            Number::make('Hut Type Biwak', 'hut_type_biwak')->nullable(),
            Number::make('Hut Type Cabane', 'hut_type_cabane')->nullable(),
            Number::make('Hut Type Other', 'hut_type_other')->nullable(),
            Number::make('Hut Type Grand Total', 'hut_type_grand_total')->nullable(),
            Number::make('Lowest Elevation Hut Type', 'hut_type_lowest_elevation')->nullable(),
            Number::make('Highest Elevation Hut Type', 'hut_type_highest_elevation')->nullable(),
        ];
    }

    //ownership fields
    public function ownershipFields()
    {
        return [
            Number::make('Mountaineering Association Ownership', 'ownership_mountaineering_association')->nullable(),
            Number::make('Mountain Club Ownership', 'ownership_mountain_club')->nullable(),
            Number::make('EOS POA SOX SEO XOS SHO XOO Ownership', 'ownership_eos_poa_sox_seo_xos_sho_xoo')->nullable(),
            Number::make('Municipality Ownership', 'ownership_municipality')->nullable(),
            Number::make('State Ownership', 'ownership_state')->nullable(),
            Number::make('Private Property Ownership', 'ownership_private_property')->nullable(),
            Number::make('Other Ownership', 'ownership_other')->nullable(),
            Number::make('Ownership Grand Total', 'ownership_grand_total')->nullable(),
        ];
    }
}
