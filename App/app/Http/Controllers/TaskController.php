<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
  public function index()
  {
    $tasks = Task::orderBy('rank')->get();
    $tasks->load('project', 'priority', 'status');
    $tasks_new = $tasks->filter(function ($task, $key) {
      return $task->status_id == 1;
    })->values();
    $tasks_work = $tasks->filter(function ($task, $key) {
      return $task->status_id == 2;
    })->values();
    $tasks_check = $tasks->filter(function ($task, $key) {
      return $task->status_id == 3;
    })->values();
    $tasks_complete = $tasks->filter(function ($task, $key) {
      return $task->status_id == 4;
    })->values();
    return response()->json([
      'tasks_new' => $tasks_new->toArray(),
      'tasks_work' => $tasks_work->toArray(),
      'tasks_check' => $tasks_check->toArray(),
      'tasks_complete' => $tasks_complete->toArray(),
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
    $old_task = Task::orderBy('rank')->first();
    if ($old_task) {
      $old_rank = $old_task->rank;
    }else{
      $old_rank = 0;
    }
    $request->validate([
      'title' => 'required|max:255',
      'body' => 'required',
    ]);

    $task = new Task([
      'title' => $request->get('title'),
      'body' => $request->get('body'),
      'date_start' => $request->get('date_start'),
      'date_end' => $request->get('date_end'),
      'manager_id' => $request->get('manager_id'),
      'project_id' => $request->get('project_id'),
      'priority_id' => $request->get('priority_id'),
      'developer_id' => $request->get('developer_id'),
      'rank' => $old_rank + 1,
      'time_estimate' => '02.06.2019',
      'time_actual' => '02.06.2019',
      'status_id' => 1
    ]);

    $task->save();

    return response()->json($task->toArray());
  }

  /**
   * Display the specified resource.
   *
   * @param  int $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $task = Task::findOrFail($id);
    $task->project = $task->project()->with('customer')->get()[0];
    $task->comments = $task->comments()->orderBy('created_at', 'desc')->get();
    $task->load('priority', 'status');
    return response()->json($task);
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
    $task = Task::findOrFail($id);
    $task->update($request->all());
    $task->project = $task->project()->with('customer')->get()[0];
    $task->comments = $task->comments()->orderBy('created_at', 'desc')->get();
    $task->load('priority', 'status');
    return response()->json($task);
  }
  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function updateAll(Request $request)
  {
    $tasks = Task::all();
    foreach ($tasks as $task) {
      $task->timestamps = false;
      $id = $task->id;
      foreach ($request->tasks as $taskFrontEnd) {
        if ($taskFrontEnd['id'] == $id) {
          $task->update(['rank' => $taskFrontEnd['rank']]);
        }
      }
    }
    return response('Update Successful.', 200);
  }
  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Task  $task
   * @return \Illuminate\Http\Response
   */
  public function updateStatus(Request $request, Task $task)
  {
    $task->status_id = $request->status_id;
    $task->save();
    return response('Update Successful.', 200);
  }
  /**
   * Remove the specified resource from storage.
   *
   * @param  int $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $task = Task::findOrFail($id);
    $task->delete();
    return response()->json('Successfully Deleted');
  }
}
