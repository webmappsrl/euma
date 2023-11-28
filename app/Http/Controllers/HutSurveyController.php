<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHutSurveyRequest;
use App\Http\Requests\UpdateHutSurveyRequest;
use App\Models\HutSurvey;

class HutSurveyController extends Controller
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
     * @param  \App\Http\Requests\StoreHutSurveyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreHutSurveyRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HutSurvey  $hutSurvey
     * @return \Illuminate\Http\Response
     */
    public function show(HutSurvey $hutSurvey)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HutSurvey  $hutSurvey
     * @return \Illuminate\Http\Response
     */
    public function edit(HutSurvey $hutSurvey)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateHutSurveyRequest  $request
     * @param  \App\Models\HutSurvey  $hutSurvey
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateHutSurveyRequest $request, HutSurvey $hutSurvey)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HutSurvey  $hutSurvey
     * @return \Illuminate\Http\Response
     */
    public function destroy(HutSurvey $hutSurvey)
    {
        //
    }
}
