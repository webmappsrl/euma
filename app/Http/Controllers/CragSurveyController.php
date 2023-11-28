<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCragSurveyRequest;
use App\Http\Requests\UpdateCragSurveyRequest;
use App\Models\CragSurvey;

class CragSurveyController extends Controller
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
     * @param  \App\Http\Requests\StoreCragSurveyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCragSurveyRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CragSurvey  $cragSurvey
     * @return \Illuminate\Http\Response
     */
    public function show(CragSurvey $cragSurvey)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CragSurvey  $cragSurvey
     * @return \Illuminate\Http\Response
     */
    public function edit(CragSurvey $cragSurvey)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCragSurveyRequest  $request
     * @param  \App\Models\CragSurvey  $cragSurvey
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCragSurveyRequest $request, CragSurvey $cragSurvey)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CragSurvey  $cragSurvey
     * @return \Illuminate\Http\Response
     */
    public function destroy(CragSurvey $cragSurvey)
    {
        //
    }
}
