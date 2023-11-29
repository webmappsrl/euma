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
            Textarea::make('Climbing Frequency')->nullable(),
            Textarea::make('Most Popular Climbing Spot')->nullable(),
            Textarea::make('Managing Rock Climbing Areas Description')->nullable(),
            Textarea::make('Other Groups Managing Rock Climbing Areas Description')->nullable(),
            Textarea::make('Money Source for Bolting and Infrastructure')->nullable(),
            Textarea::make('Legal Responsibility of Equippers')->nullable(),
            Textarea::make('Rock Climbing Areas Bans')->nullable(),
            Textarea::make('Rock Climbing Areas Limitations')->nullable(),
            Textarea::make('Limitations Imposing Authority')->nullable(),
            Textarea::make('Limitations Efficiency')->nullable(),
            Textarea::make('Micro-Zoning Examples')->nullable(),
            Textarea::make('Disputes Nature Protection')->nullable(),
            Textarea::make('Disputes Local Population')->nullable(),
            Textarea::make('Disputes Overcrowding')->nullable(),
            Textarea::make('Disputes Ownership')->nullable(),
            Textarea::make('Disputes Access')->nullable(),
            Textarea::make('Disputes Littering')->nullable(),
            Textarea::make('Disputes Wild Camping')->nullable(),
            Textarea::make('Other Problems')->nullable(),
            Textarea::make('Liability Climbing Accidents')->nullable(),
            Textarea::make('Good Practice Examples')->nullable(),
            Textarea::make('Bad Practice Examples')->nullable(),
            TextArea::make('Is Climbing Tourism Country')->nullable(),
            Textarea::make('Climbing Destination Season Preferred Regions Countries')->nullable(),
            Textarea::make('Regions with Significant Climbing Tourism Income')->nullable(),
            Textarea::make('Crags Developed with Tourism Funds')->nullable(),
            Textarea::make('Experiences with Climbing Tourists')->nullable(),
            Textarea::make('Countries Visited by Climbers')->nullable(),
            Textarea::make('Tourist Associations Promoting Climbing')->nullable(),
            Textarea::make('Assessing Climbing Tourism Potential')->nullable(),
            Textarea::make('Official Climbing Ethics')->nullable(),
            Textarea::make('Obedience to Climbing Ethics')->nullable(),
            Textarea::make('Area Specific Climbing Ethics')->nullable(),
            Textarea::make('Bolting Licences and Manuals')->nullable(),
            Textarea::make('Responsibility for Equipment Failure')->nullable(),
            Textarea::make('Potential for New Climbing Areas')->nullable(),
            Textarea::make('Cooperation with Climbing Stakeholders')->nullable(),
            Textarea::make('Cooperation with Non-Climbing Stakeholders')->nullable(),
            Textarea::make('Association Involvement Outdoor Rock Climbing Area')->nullable(),
            Textarea::make('Procedure to Create New Climbing Areas')->nullable(),
            Textarea::make('Statistics Databases Rock Climbing Areas')->nullable(),
            Textarea::make('Guidebooks in Country')->nullable(),
            Textarea::make('Other Sources on Rock Climbing')->nullable(),
            Textarea::make('Estimated People Sport Climbing')->nullable(),
            Textarea::make('Estimated People Climbing in Gym')->nullable(),
            Textarea::make('Estimated People Bouldering')->nullable(),
            Textarea::make('Estimated People Alpine Climbing')->nullable(),
            Textarea::make('Estimated People Ice Climbing')->nullable(),
            Textarea::make('Estimated People Drytooling')->nullable(),
            Textarea::make('Estimated People Via Ferrata')->nullable(),
            Textarea::make('Trends Sport Climbing')->nullable(),
            Textarea::make('Trends Gym Climbing')->nullable(),
            Textarea::make('Trends Bouldering')->nullable(),
            Textarea::make('Trends Alpine Climbing')->nullable(),
            Textarea::make('Trends Ice Climbing Dry Tooling')->nullable(),
            Textarea::make('Other Climbing Sport Trends')->nullable(),
            Textarea::make('Significance of Trad Aid Climbing')->nullable(),
            Textarea::make('Development of Climbers in Last 20 Years')->nullable(),
            Textarea::make('Number of Climbing Gyms')->nullable(),
            Textarea::make('Artificial Climbing Infrastructure Description')->nullable(),
            Textarea::make('Association Members Climbers')->nullable(),
            Textarea::make('People Climbing in Country')->nullable(),
            Textarea::make('Is Official Number')->nullable(),
            Textarea::make('Number of Rock Climbing Areas')->nullable(),
            Textarea::make('Number of Bouldering Spots Problems')->nullable(),
            Textarea::make('Other Climbing Related Sports')->nullable(),
            Textarea::make('Additional Information')->nullable(),
        ];
    }
}
