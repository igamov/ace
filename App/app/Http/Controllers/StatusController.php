<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Status;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
  public function index()
  {
    $statuses = Status::all();

    return response()->json([
      'statuses' => $statuses->toArray()
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
    ]);
    $status = new Status([
      'title' => $request->get('title'),
    ]);

    $status->save();

    return response()->json($status->toArray());
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $status = Status::findOrFail($id);
    return response()->json($status->toArray());
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
    $status = Status::findOrFail($id);
    $status->update($request->all());
    return response()->json($status->toArray());
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $status = Status::findOrFail($id);
    $status->delete();
    return response()->json('Successfully Deleted');
  }
}
