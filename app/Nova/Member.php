<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\URL;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Image;

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
        'id','name_en','acronym'
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
            Text::make(__('Name en'),'name_en')->rules('required'),
            Text::make(__('Name Orig'),'name_orig')->rules('required')->hideFromIndex(),
            Text::make(__('Acronym'),'acronym')->rules('required'),
            Text::make(__('Country'),'country')->rules('required'),
            URL::make(__('Web'),'web')->displayUsing(fn () => "$this->web")->hideFromIndex(),  
            Number::make(__('Members'),'members'),
            Number::make(__('Since'),'since')->rules('required'),
            Select::make(__('Type'), 'type')->hideFromIndex()->options([
                'FULL' => 'FULL',
                'SPONSOR' => 'SPONSOR',
                'PARTNER' => 'PARTNER',
                'ASSOCIATED' => 'ASSOCIATED',
                'AGREEMENT' => 'AGREEMENT',
                'COLLABORATING' => 'COLLABORATING',
                'LOOSE-EXCHANGE' => 'LOOSE EXCHANGE',
                'EUMA-IS-MEMBER' => 'EUMA IS MEMBER',
                'EXTERNAL-MEMBER' => 'EXTERNAL MEMBER'
            ])->displayUsingLabels()->rules('required'),
            Image::make(__('Icon'), 'icon')
                ->disk('public')
                ->path('/member/' . $this->model()->id . '/resources')
                ->storeAs(function () {
                    return 'icon.png';
                })
                ->hideFromIndex(),
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
