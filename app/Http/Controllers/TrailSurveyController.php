<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTrailSurveyRequest;
use App\Http\Requests\UpdateTrailSurveyRequest;
use App\Models\TrailSurvey;

class TrailSurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTrailSurveyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTrailSurveyRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TrailSurvey  $trailSurvey
     * @return \Illuminate\Http\Response
     */
    public function show(TrailSurvey $trailSurvey)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TrailSurvey  $trailSurvey
     * @return \Illuminate\Http\Response
     */
    public function edit(TrailSurvey $trailSurvey)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTrailSurveyRequest  $request
     * @param  \App\Models\TrailSurvey  $trailSurvey
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTrailSurveyRequest $request, TrailSurvey $trailSurvey)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TrailSurvey  $trailSurvey
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrailSurvey $trailSurvey)
    {
        //
    }
}
