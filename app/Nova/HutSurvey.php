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
            Number::make('Mechanical + Biological Wastewater Treatment', 'wastewater_mechanical_plus_biological_treatment')->nullable()->hideFromIndex(),
            Number::make('Mechanical + Biological Wastewater Treatment Percentage', 'wastewater_mechanical_plus_biological_treatment_percentage')->nullable()->hideFromIndex(),
            Number::make('No Wastewater Treatment', 'wastewater_no_treatment')->nullable()->hideFromIndex(),
            Number::make('No Wastewater Treatment Percentage', 'wastewater_no_treatment_percentage')->nullable()->hideFromIndex(),
            Number::make('Public Grid Wastewater', 'wastewater_public_grid')->nullable()->hideFromIndex(),
            Number::make('Public Grid Wastewater Percentage', 'wastewater_public_grid_percentage')->nullable()->hideFromIndex(),
            Number::make('Unspecified Wastewater', 'wastewater_unspecified')->nullable()->hideFromIndex(),
            Number::make('Unspecified Wastewater Percentage', 'wastewater_unspecified_percentage')->nullable()->hideFromIndex(),
            Number::make('Wastewater Treatment Grand Total', 'wastewater_treatment_grand_total')->nullable()->hideFromIndex(),
        ];
    }

    //waste management fields
    public function wasteManagementFields()
    {
        return [
            Number::make('Waste Management System Yes', 'waste_management_system_yes')->nullable()->hideFromIndex(),
            Number::make('Waste Management System Yes Percentage', 'waste_management_system_yes_percentage')->nullable()->hideFromIndex(),
            Number::make('Waste Management System No', 'waste_management_system_no')->nullable()->hideFromIndex(),
            Number::make('Waste Management System No Percentage', 'waste_management_system_no_percentage')->nullable()->hideFromIndex(),
            Number::make('Waste Management System Grand Total', 'waste_management_system_grand_total')->nullable()->hideFromIndex(),
        ];
    }

    //water supply fields
    public function waterSupplyFields()
    {
        return [
            Number::make('Surface Water Supply', 'surface_water_supply')->nullable()->hideFromIndex(),
            Number::make('Surface Water Supply Percentage', 'surface_water_supply_percentage')->nullable()->hideFromIndex(),
            Number::make('Ground Well Water Supply', 'ground_well_water_supply')->nullable()->hideFromIndex(),
            Number::make('Ground Well Water Supply Percentage', 'ground_well_water_supply_percentage')->nullable()->hideFromIndex(),
            Number::make('Public Supply', 'public_supply')->nullable()->hideFromIndex(),
            Number::make('Public Supply Percentage', 'public_supply_percentage')->nullable()->hideFromIndex(),
            Number::make('No Water Supply', 'no_water_supply')->nullable()->hideFromIndex(),
            Number::make('No Water Supply Percentage', 'no_water_supply_percentage')->nullable()->hideFromIndex(),
            Number::make('Water Supply Grand Total', 'water_supply_grand_total')->nullable()->hideFromIndex(),
        ];
    }

    //source of energy fields
    public function sourceOfEnergyFields()
    {
        return [
            Number::make('Public Grid Energy Source', 'source_of_energy_public_grid')->nullable()->hideFromIndex(),
            Number::make('Public Grid Energy Source Percentage', 'source_of_energy_public_grid_percentage')->nullable()->hideFromIndex(),
            Number::make('Renewable Energy Source', 'source_of_energy_renewable')->nullable()->hideFromIndex(),
            Number::make('Renewable Energy Source Percentage', 'source_of_energy_renewable_percentage')->nullable()->hideFromIndex(),
            Number::make('Generator Energy Source', 'source_of_energy_generator')->nullable()->hideFromIndex(),
            Number::make('Generator Energy Source Percentage', 'source_of_energy_generator_percentage')->nullable()->hideFromIndex(),
            Number::make('No Energy Source', 'no_source_of_energy')->nullable()->hideFromIndex(),
            Number::make('No Energy Source Percentage', 'no_source_of_energy_percentage')->nullable()->hideFromIndex(),
            Number::make('Source of Energy Grand Total', 'source_of_energy_grand_total')->nullable()->hideFromIndex(),
        ];
    }

    //national park fields
    public function nationalParkFields()
    {
        return [
            Number::make('National Parks', 'national_parks')->nullable()->hideFromIndex(),
            Number::make('National Parks Percentage', 'national_parks_percentage')->nullable()->hideFromIndex(),
            Number::make('Protected Areas', 'protected_areas')->nullable()->hideFromIndex(),
            Number::make('Protected Areas Percentage', 'protected_areas_percentage')->nullable()->hideFromIndex(),
            Number::make('No National Parks', 'no_national_parks')->nullable()->hideFromIndex(),
            Number::make('No National Parks Percentage', 'no_national_parks_percentage')->nullable()->hideFromIndex(),
            Number::make('National Parks Grand Total', 'national_parks_grand_total')->nullable()->hideFromIndex(),
        ];
    }

    //sanitary fields
    public function sanitaryFields()
    {
        return [
            Number::make('Dry Toilets Sanitary', 'sanitary_dry_toilets')->nullable()->hideFromIndex(),
            Number::make('Wet Toilets Sanitary', 'sanitary_wet_toilets')->nullable()->hideFromIndex(),
            Number::make('Separation Toilets Sanitary', 'sanitary_toilets_separation')->nullable()->hideFromIndex(),
            Number::make('Total Toilets Sanitary', 'sanitary_toilets')->nullable()->hideFromIndex(),
            Number::make('Showers Sanitary', 'sanitary_showers')->nullable()->hideFromIndex(),
            Number::make('Total With Toilets Sanitary', 'sanitary_total_with_toilets')->nullable()->hideFromIndex(),
            Number::make('Total With Toilets Percentage Sanitary', 'sanitary_total_with_toilets_percentage')->nullable()->hideFromIndex(),
            Number::make('Total Without Toilets Sanitary', 'sanitary_total_without_toilets')->nullable()->hideFromIndex(),
            Number::make('Total Without Toilets Percentage Sanitary', 'sanitary_total_without_toilets_percentage')->nullable()->hideFromIndex(),
        ];
    }

    //kitchen fields
    public function kitchenFields()
    {
        return [
            Number::make('Electric Kitchen', 'electric_kitchen')->nullable()->hideFromIndex(),
            Number::make('Electric Kitchen Percentage', 'electric_kitchen_percentage')->nullable()->hideFromIndex(),
            Number::make('Gas Kitchen', 'gas_kitchen')->nullable()->hideFromIndex(),
            Number::make('Gas Kitchen Percentage', 'gas_kitchen_percentage')->nullable()->hideFromIndex(),
            Number::make('Wood Kitchen', 'wood_kitchen')->nullable()->hideFromIndex(),
            Number::make('Wood Kitchen Percentage', 'wood_kitchen_percentage')->nullable()->hideFromIndex(),
            Number::make('No Kitchen', 'no_kitchen')->nullable()->hideFromIndex(),
            Number::make('No Kitchen Percentage', 'no_kitchen_percentage')->nullable()->hideFromIndex(),
            Number::make('Kitchen Grand Total', 'kitchen_grand_total')->nullable()->hideFromIndex(),
        ];
    }

    //hut type fields
    public function hutTypeFields()
    {
        return [
            Number::make('Hut Type Hut', 'hut_type_hut')->nullable()->hideFromIndex(),
            Number::make('Hut Type Biwak', 'hut_type_biwak')->nullable()->hideFromIndex(),
            Number::make('Hut Type Cabane', 'hut_type_cabane')->nullable()->hideFromIndex(),
            Number::make('Hut Type Other', 'hut_type_other')->nullable()->hideFromIndex(),
            Number::make('Hut Type Grand Total', 'hut_type_grand_total')->nullable()->hideFromIndex(),
            Number::make('Lowest Elevation Hut Type', 'hut_type_lowest_elevation')->nullable()->hideFromIndex(),
            Number::make('Highest Elevation Hut Type', 'hut_type_highest_elevation')->nullable()->hideFromIndex(),
        ];
    }

    //ownership fields
    public function ownershipFields()
    {
        return [
            Number::make('Mountaineering Association Ownership', 'ownership_mountaineering_association')->nullable()->hideFromIndex(),
            Number::make('Mountain Club Ownership', 'ownership_mountain_club')->nullable()->hideFromIndex(),
            Number::make('EOS POA SOX SEO XOS SHO XOO Ownership', 'ownership_eos_poa_sox_seo_xos_sho_xoo')->nullable()->hideFromIndex(),
            Number::make('Municipality Ownership', 'ownership_municipality')->nullable()->hideFromIndex(),
            Number::make('State Ownership', 'ownership_state')->nullable()->hideFromIndex(),
            Number::make('Private Property Ownership', 'ownership_private_property')->nullable()->hideFromIndex(),
            Number::make('Other Ownership', 'ownership_other')->nullable()->hideFromIndex(),
            Number::make('Ownership Grand Total', 'ownership_grand_total')->nullable()->hideFromIndex(),
        ];
    }
}
