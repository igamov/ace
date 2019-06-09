<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
  public function index()
  {
    $services = Service::all();

    return response()->json([
      'services' => $services->toArray()
    ]);
  }


  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $request->validate([
      'title' => 'required|max:255',
      'price' => 'required',
      'sum' => 'required',
      'nds_id' => 'required',
      'invoice_id' => 'required'
    ]);
    $service = new Service([
      'title' => $request->get('title'),
      'price' => $request->get('price'),
      'sum' => $request->get('sum'),
      'nds_id' => $request->get('nds_id'),
      'invoice_id' => $request->get('invoice_id'),
    ]);

    $service->save();

    return response()->json($service->toArray());
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $service = Service::findOrFail($id);
    return response()->json($service->toArray());
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
    $service = Service::findOrFail($id);
    $service->update($request->all());
    return response()->json($service->toArray());
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $service = Service::findOrFail($id);
    $service->delete();
    return response()->json('Successfully Deleted');
  }
}
