<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Note;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
  public function index()
  {
    $notes = Note::all();
    $notes->load('user');
    return response()->json([
      'notes' => $notes->toArray()
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
      'body' => 'required|max:255',
    ]);
    $note = new Note([
      'user_id' => $request->get('user_id'),
      'project_id' => $request->get('project_id'),
      'body' => $request->get('body'),
    ]);

    $note->save();
    $note->load('user');

    return response()->json($note->toArray());
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $note = Note::findOrFail($id);
    return response()->json($note->toArray());
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
    $note = Note::findOrFail($id);
    $note->update($request->all());
    return response()->json($note->toArray());
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $note = Note::findOrFail($id);
    $note->delete();
    return response()->json('Successfully Deleted');
  }
}
