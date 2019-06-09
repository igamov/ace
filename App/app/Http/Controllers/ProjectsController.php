<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Project;

class ProjectsController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $projects = Project::get();
    $projects->load('customer', 'priority');

    return response()->json([
      'projects' => $projects->toArray()
    ]);

  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $request->validate([
      'title' => 'required|max:255',
      'body' => 'required',
    ]);
    $project = new Project([
      'title' => $request->get('title'),
      'body' => $request->get('body'),
      'date_start' => $request->get('date_start'),
      'date_end' => $request->get('date_end'),
      'manager_id' => $request->get('manager_id'),
      'customer_id' => $request->get('customer_id'),
      'priority_id' => $request->get('priority_id'),
      'team_id' => $request->get('team_id')
    ]);

    $project->save();

    return response()->json($project->toArray());
  }

  /**
   * Display the specified resource.
   *
   * @param  int $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $project = Project::findOrFail($id);
    return response()->json($project->load('customer', 'priority'));
  }


  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  int $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $project = Project::findOrFail($id);
    $project->update($request->all());
    return response()->json($project->toArray());
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $project = Project::findOrFail($id);
    $project->delete();
    return response()->json('Successfully Deleted');
  }
}
