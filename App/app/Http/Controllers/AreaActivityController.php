<?php

namespace App\Http\Controllers;

use App\AreaActivity;
use Illuminate\Http\Request;

class AreaActivityController extends Controller
{
  public function index()
  {
    $area_activities = AreaActivity::all();

    return response()->json([
      'area_activities' => $area_activities->toArray()
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
      'title' => 'required|unique:area_activities,title|max:255',
    ]);
    $area_activity = new AreaActivity([
      'title' => $request->get('title'),
    ]);

    $area_activity->save();

    return response()->json($area_activity->toArray());
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $area_activity = AreaActivity::findOrFail($id);
    return response()->json($area_activity->toArray());
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
    $request->validate([
      'title' => 'required|unique:area_activities,title|max:255',
    ]);
    $area_activity = AreaActivity::findOrFail($id);
    $area_activity->update($request->all());
    return response()->json($area_activity->toArray());
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $area_activity = AreaActivity::findOrFail($id);
    $area_activity->delete();
    return response()->json('Successfully Deleted');
  }
}
