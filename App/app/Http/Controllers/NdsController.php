<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Nds;

class NdsController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $nds = Nds::all();

    return response()->json([
      'nds' => $nds->toArray()
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
      'percent' => 'required',
    ]);
    $nds = new Nds([
      'title' => $request->get('title'),
      'percent' => $request->get('percent'),
    ]);

    $nds->save();

    return response()->json($nds->toArray());
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $nds = Nds::findOrFail($id);
    return response()->json($nds->toArray());
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
    $nds = Nds::findOrFail($id);
    $nds->update($request->all());
    return response()->json($nds->toArray());
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $nds = Nds::findOrFail($id);
    $nds->delete();
    return response()->json('Successfully Deleted');
  }
}
