<?php

namespace App\Http\Controllers;

use App\CompanyDetail;
use Illuminate\Http\Request;

class CompanyDetailController extends Controller
{

/**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $company_detail = CompanyDetail::findOrFail($id);
      return response()->json($company_detail->toArray());
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $company_detail = CompanyDetail::findOrFail($id);
      $company_detail->update($request->all());
      return response()->json($company_detail->toArray());
    }


}
