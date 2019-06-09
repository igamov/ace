<?php

namespace App\Http\Controllers;

use App\Priority;
use Illuminate\Http\Request;

class PriorityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $priorities = Priority::all();

      return response()->json([
        'priorities' => $priorities->toArray()
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
        'color' => 'required',
      ]);
      $priority = new Priority([
        'title' => $request->get('title'),
        'color' => $request->get('color'),
      ]);

      $priority->save();

      return response()->json($priority->toArray());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $priority = Priority::findOrFail($id);
      return response()->json($priority->toArray());
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
      $priority = Priority::findOrFail($id);
      $priority->update($request->all());
      return response()->json($priority->toArray());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $priority = Priority::findOrFail($id);
      $priority->delete();
      return response()->json('Successfully Deleted');
    }
}
