<?php

namespace App\Providers;

use App\Nova\Hut;
use App\Nova\Trail;
use App\Nova\ClimbingRockArea;
use App\Nova\ClimbingRockType;
use App\Nova\ClimbingStyle;
use App\Nova\ExternalDatabase;
use App\Nova\Member;
use Illuminate\Support\Facades\Gate;
use App\Nova\User;
use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Nova\Dashboards\Main;
use Laravel\Nova\Menu\Menu;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Nova::userTimezone(function (Request $request) {
            return $request->user()?->timezone;
        });

        Nova::mainMenu(function (Request $request) {
            return [
                // MenuSection::dashboard(Main::class)->icon('chart-bar'),

                MenuSection::make('Content', [
                    MenuItem::resource(Hut::class),
                    MenuItem::resource(Trail::class),
                    MenuItem::resource(ClimbingRockArea::class),
                    MenuItem::resource(Member::class)->canSee(function (NovaRequest $request) {
                        return !$request->user()->is_admin;
                    }),
                ])->icon('document-text')->collapsable(),


                MenuSection::make('Admin', [
                    MenuItem::resource(ClimbingRockType::class),
                    MenuItem::resource(ClimbingStyle::class),
                    MenuItem::resource(ExternalDatabase::class),
                    MenuItem::resource(User::class),
                    MenuItem::resource(Member::class)->canSee(function (NovaRequest $request) {
                        return $request->user()->is_admin;
                    }),
                ])->icon('user')->collapsable()->canSee(function (NovaRequest $request) {
                    return $request->user()->is_admin;
                }),

                MenuSection::make('Export', [
                    MenuItem::externalLink('Huts GeoJSON', '/api/v1/hut/geojson'),
                    MenuItem::externalLink('Climbing Rock Areas GeoJSON', '/api/v1/climbingrockarea/geojson'),
                    MenuItem::externalLink('Trails CSV', '/api/v1/trail/csv'),
                ])->icon('download')->collapsable()->canSee(function (NovaRequest $request) {
                    return $request->user()->is_admin;
                }),
            ];
        });
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
            ->withAuthenticationRoutes()
            ->withPasswordResetRoutes()
            ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return true;
        });
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [
            new \App\Nova\Dashboards\Main,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
