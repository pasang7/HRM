<?php

namespace App\Http\Controllers;

use App\ContractType;
use Illuminate\Http\Request;

class ContractTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        dd('contract');
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ContractType  $contractType
     * @return \Illuminate\Http\Response
     */
    public function show(ContractType $contractType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ContractType  $contractType
     * @return \Illuminate\Http\Response
     */
    public function edit(ContractType $contractType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ContractType  $contractType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContractType $contractType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ContractType  $contractType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContractType $contractType)
    {
        //
    }
}
