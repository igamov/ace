<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Project;

class ProjectsController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */

  public function all()
  {
    $projects = Project::all();
    $projects->load('customer', 'priority', 'manager');
    return response()->json([
      'projects' => $projects->toArray()
    ]);
    }

  /**
   * Display a listing of the resource.
   *
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $projects = Project::all();
    $projects->load('customer', 'priority', 'manager');
    if($request->user_id){
      $user_id = $request->user_id;
      $user = User::findOrFail($user_id);
      if ($user) {
        $user_role = $user->role->name;
        switch ($user_role) {
          case 'manager':
            $projects = $projects->where('manager_id', $user_id);
            break;
          case 'customer':
            $customer_ids = $user->spoke_customers->pluck('id');
            $projects = $projects->whereIn('customer_id', $customer_ids);
            break;
        }
      }
    }

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
      'title' => 'required|unique:projects|max:255',
      'body' => 'required',
      'date_start' => 'required|date_format:d.m.Y',
      'date_end' => 'required|date_format:d.m.Y',
      'manager_id' => 'required|integer',
      'customer_id' => 'required|integer',
      'priority_id' => 'required|integer',
    ]);
    $date_start = explode('.', $request->get('date_start'));
    $date_start = Carbon::createFromDate($date_start[2], $date_start[1], $date_start[0]);
    $date_end = explode('.', $request->get('date_end'));
    $date_end = Carbon::createFromDate($date_end[2], $date_end[1], $date_end[0]);
    $project = new Project([
      'title' => $request->get('title'),
      'body' => $request->get('body'),
      'date_start' => $date_start,
      'date_end' => $date_end,
      'manager_id' => $request->get('manager_id'),
      'customer_id' => $request->get('customer_id'),
      'priority_id' => $request->get('priority_id'),
      'team_id' => 1
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
    $project->notes = $project->notes()->with('user')->orderBy('created_at', 'desc')->get();
    return response()->json($project->load('customer', 'priority', 'manager'));
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
