<?php

namespace App\Nova;

use Eminiarts\Tabs\Tab;
use Eminiarts\Tabs\Tabs;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\URL;
use App\Enums\MemberTypeEnum;
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
use Laravel\Nova\Fields\FormData;
use Laravel\Nova\Fields\Textarea;
use Eminiarts\Tabs\Traits\HasTabs;
use Laravel\Nova\Fields\MultiSelect;
use App\Enums\MaintenanceOperatorTypes;
use Carbon\Carbon;
use Laravel\Nova\Http\Requests\NovaRequest;

class Member extends Resource
{
    use HasTabs;
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

    // public static function label()
    // {
    //     if (!auth()->user()->is_admin == true) {
    //         return 'My Member';
    //     }
    //     return 'Members';
    // }

    public static function indexQuery(NovaRequest $request, $query)
    {
        if ($request->user()->is_admin == true) {
            return $query;
        }
        return $query->where('id', $request->user()->member_id);
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
            Tabs::make('Member', [
                Tab::make('Member Info', [
                    ID::make()->sortable(),
                    Text::make(__('Name en'), 'name_en')
                        ->rules('required')
                        ->sortable(),
                    Text::make(__('Name Orig'), 'name_orig')
                        ->rules('required')
                        ->hideFromIndex(),
                    Text::make(__('Acronym'), 'acronym')
                        ->rules('required')
                        ->sortable(),
                    Text::make(__('Country'), 'country')
                        ->rules('required')
                        ->sortable(),
                    URL::make(__('Web'), 'web')
                        ->displayUsing(fn () => "$this->web")
                        ->hideFromIndex(),
                    Number::make(__('Members'), 'members')
                        ->sortable(),
                    Number::make(__('Since'), 'since')
                        ->rules('required')
                        ->sortable(),
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
                        ->rules('max:255')
                        ->hideFromIndex(),

                    Text::make(__('Contact Role'), 'contact_role')
                        ->hideFromIndex()
                        ->nullable()
                        ->rules('max:255')
                        ->hideFromIndex(),

                    Text::make(__('Contact Email'), 'contact_email')
                        ->hideFromIndex()
                        ->nullable()
                        ->rules('max:255')
                        ->hideFromIndex(),

                    Text::make(__('Contact Phone'), 'contact_phone')
                        ->hideFromIndex()
                        ->nullable()
                        ->rules('max:255')
                        ->hideFromIndex(),


                    Date::make(__('Contact Completion Date'), 'contact_completion_date')
                        ->hideFromIndex()
                        ->nullable()
                        ->withMeta(['value' => Carbon::now()]),
                ]),
            ])->withToolbar(),
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
                new MemberType()
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
