<?php

namespace App\Nova;

use Eminiarts\Tabs\Tab;
use Eminiarts\Tabs\Tabs;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Http\Requests\NovaRequest;

class CragSurvey extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\CragSurvey>
     */
    public static $model = \App\Models\CragSurvey::class;

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
            ID::make()->sortable(),
            Tabs::make('Crags Survey', [
                Tab::make('General Informations', $this->generalInformationFields()),
                Tab::make('Survey Responses', $this->surveyResponseFields())
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
        return [
            (new Actions\ImportCragSurvey)->canSee(function ($request) {
                return $request->user()->is_admin == true;
            })->standalone(),
        ];
    }

    protected function generalInformationFields()
    {
        return [
            BelongsTo::make('Member')->searchable(),
            Text::make('Respondent Name and Role')->nullable()->hideFromIndex(),
            Text::make('Respondent Mail')->nullable()->hideFromIndex(),
            DateTime::make('Created At')->nullable()->hideFromIndex(),
        ];
    }

    protected function surveyResponseFields()
    {
        return [
            Textarea::make('Climbing Frequency')->nullable()->alwaysShow(),
            Textarea::make('Most Popular Climbing Spot')->nullable()->alwaysShow(),
            Textarea::make('Managing Rock Climbing Areas Description')->nullable()->alwaysShow(),
            Textarea::make('Other Groups Managing Rock Climbing Areas Description')->nullable()->alwaysShow(),
            Textarea::make('Money Source for Bolting and Infrastructure')->nullable()->alwaysShow(),
            Textarea::make('Legal Responsibility of Equippers')->nullable()->alwaysShow(),
            Textarea::make('Rock Climbing Areas Bans')->nullable()->alwaysShow(),
            Textarea::make('Rock Climbing Areas Limitations')->nullable()->alwaysShow(),
            Textarea::make('Limitations Imposing Authority')->nullable()->alwaysShow(),
            Textarea::make('Limitations Efficiency')->nullable()->alwaysShow(),
            Textarea::make('Micro-Zoning Examples')->nullable()->alwaysShow(),
            Textarea::make('Disputes Nature Protection')->nullable()->alwaysShow(),
            Textarea::make('Disputes Local Population')->nullable()->alwaysShow(),
            Textarea::make('Disputes Overcrowding')->nullable()->alwaysShow(),
            Textarea::make('Disputes Ownership')->nullable()->alwaysShow(),
            Textarea::make('Disputes Access')->nullable()->alwaysShow(),
            Textarea::make('Disputes Littering')->nullable()->alwaysShow(),
            Textarea::make('Disputes Wild Camping')->nullable()->alwaysShow(),
            Textarea::make('Other Problems')->nullable()->alwaysShow(),
            Textarea::make('Liability Climbing Accidents')->nullable()->alwaysShow(),
            Textarea::make('Good Practice Examples')->nullable()->alwaysShow(),
            Textarea::make('Bad Practice Examples')->nullable()->alwaysShow(),
            TextArea::make('Is Climbing Tourism Country')->nullable()->alwaysShow(),
            Textarea::make('Climbing Destination Season Preferred Regions Countries')->nullable()->alwaysShow(),
            Textarea::make('Regions with Significant Climbing Tourism Income')->nullable()->alwaysShow(),
            Textarea::make('Crags Developed with Tourism Funds')->nullable()->alwaysShow(),
            Textarea::make('Experiences with Climbing Tourists')->nullable()->alwaysShow(),
            Textarea::make('Countries Visited by Climbers')->nullable()->alwaysShow(),
            Textarea::make('Tourist Associations Promoting Climbing')->nullable()->alwaysShow(),
            Textarea::make('Assessing Climbing Tourism Potential')->nullable()->alwaysShow(),
            Textarea::make('Official Climbing Ethics')->nullable()->alwaysShow(),
            Textarea::make('Obedience to Climbing Ethics')->nullable()->alwaysShow(),
            Textarea::make('Area Specific Climbing Ethics')->nullable()->alwaysShow(),
            Textarea::make('Bolting Licences and Manuals')->nullable()->alwaysShow(),
            Textarea::make('Responsibility for Equipment Failure')->nullable()->alwaysShow(),
            Textarea::make('Potential for New Climbing Areas')->nullable()->alwaysShow(),
            Textarea::make('Cooperation with Climbing Stakeholders')->nullable()->alwaysShow(),
            Textarea::make('Cooperation with Non-Climbing Stakeholders')->nullable()->alwaysShow(),
            Textarea::make('Association Involvement Outdoor Rock Climbing Area')->nullable()->alwaysShow(),
            Textarea::make('Procedure to Create New Climbing Areas')->nullable()->alwaysShow(),
            Textarea::make('Statistics Databases Rock Climbing Areas')->nullable()->alwaysShow(),
            Textarea::make('Guidebooks in Country')->nullable()->alwaysShow(),
            Textarea::make('Other Sources on Rock Climbing')->nullable()->alwaysShow(),
            Textarea::make('Estimated People Sport Climbing')->nullable()->alwaysShow(),
            Textarea::make('Estimated People Climbing in Gym')->nullable()->alwaysShow(),
            Textarea::make('Estimated People Bouldering')->nullable()->alwaysShow(),
            Textarea::make('Estimated People Alpine Climbing')->nullable()->alwaysShow(),
            Textarea::make('Estimated People Ice Climbing')->nullable()->alwaysShow(),
            Textarea::make('Estimated People Drytooling')->nullable()->alwaysShow(),
            Textarea::make('Estimated People Via Ferrata')->nullable()->alwaysShow(),
            Textarea::make('Trends Sport Climbing')->nullable()->alwaysShow(),
            Textarea::make('Trends Gym Climbing')->nullable()->alwaysShow(),
            Textarea::make('Trends Bouldering')->nullable()->alwaysShow(),
            Textarea::make('Trends Alpine Climbing')->nullable()->alwaysShow(),
            Textarea::make('Trends Ice Climbing Dry Tooling')->nullable()->alwaysShow(),
            Textarea::make('Other Climbing Sport Trends')->nullable()->alwaysShow(),
            Textarea::make('Significance of Trad Aid Climbing')->nullable()->alwaysShow(),
            Textarea::make('Development of Climbers in Last 20 Years')->nullable()->alwaysShow(),
            Textarea::make('Number of Climbing Gyms')->nullable()->alwaysShow(),
            Textarea::make('Artificial Climbing Infrastructure Description')->nullable()->alwaysShow(),
            Textarea::make('Association Members Climbers')->nullable()->alwaysShow(),
            Textarea::make('People Climbing in Country')->nullable()->alwaysShow(),
            Textarea::make('Is Official Number')->nullable()->alwaysShow(),
            Textarea::make('Number of Rock Climbing Areas')->nullable()->alwaysShow(),
            Textarea::make('Number of Bouldering Spots Problems')->nullable()->alwaysShow(),
            Textarea::make('Other Climbing Related Sports')->nullable()->alwaysShow(),
            Textarea::make('Additional Information')->nullable()->alwaysShow(),
        ];
    }
}
