<?php

namespace App\Http\Controllers;

use App\History;
use App\Status;
use Illuminate\Http\Request;
use App\Task;
use App\User;
use Carbon\Carbon;

class TaskController extends Controller
{
  /**
 * Display a listing of the resource.
 * @param  \Illuminate\Http\Request $request
 * @return \Illuminate\Http\Response
 */
  public function all(Request $request){
    $tasks = Task::orderBy('priority_id', 'desc')->get();
    $tasks->load('project', 'priority', 'status');
    $user_id = $request->user_id;
    $user = User::findOrFail($user_id);
    if ($user) {
      $user_role = $user->role->name;
      switch ($user_role) {
        case 'manager':
          $tasks = $tasks->where('manager_id', $user_id);
          break;
        case 'developer':
          $tasks = $tasks->where('developer_id', $user_id);
          break;
      }
    }
    return response()->json([
      'tasks' => $tasks->toArray()
    ]);
  }
    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
  public function index(Request $request)
  {
    if ($request->project_id) {
      $tasks = Task::where('project_id', $request->project_id)->orderBy('rank')->get();
    }else{
      $tasks = Task::orderBy('rank')->get();
    }
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
      'date_start' => 'required|date_format:d.m.Y',
      'date_end' => 'required|date_format:d.m.Y',
      'manager_id' => 'required|integer',
      'project_id' => 'required|integer',
      'developer_id' => 'required|integer',
      'priority_id'  => 'required|integer',
      'user_id' => 'required|integer'
    ]);
    $date_start = explode('.', $request->get('date_start'));
    $date_start = Carbon::createFromDate($date_start[2], $date_start[1], $date_start[0]);
    $date_end = explode('.', $request->get('date_end'));
    $date_end = Carbon::createFromDate($date_end[2], $date_end[1], $date_end[0]);
    $task = new Task([
      'title' => $request->get('title'),
      'body' => $request->get('body'),
      'date_start' => $date_start,
      'date_end' => $date_end,
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

    $history = new History([
      'body' => 'Создана задача',
      'user_id' => $request->get('user_id'),
      'task_id' => $task->id,
    ]);
    $history->save();

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
    $task->project = $task->project()->with('customer')->with('manager')->get()[0];
    $task->comments = $task->comments()->with('user')->orderBy('created_at', 'desc')->get();
    $task->histories = $task->history()->with('user')->orderBy('created_at', 'desc')->get();
    $task->load('developer','priority', 'status');
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
    if($request->get('action') == 'update_status' && $request->get('user_id')) {
      $old_status = $task->status->title;
      $new_status = Status::findOrFail($request->task['status_id'])->title;
      $history = new History([
        'body' => 'Изменен статус с '.$old_status.' на '.$new_status,
        'user_id' => $request->get('user_id'),
        'task_id' => $task->id,
      ]);
      $history->save();
    }

    $task->update($request->task);
    $task->project = $task->project()->with('customer')->with('manager')->get()[0];
    $task->comments = $task->comments()->with('user')->orderBy('created_at', 'desc')->get();
    $task->histories = $task->history()->with('user')->orderBy('created_at', 'desc')->get();
    $task->load('developer','priority', 'status');
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
    $old_status = $task->status->title;
    $task->status_id = $request->status_id;
    $task->save();
    $new_status = Status::findOrFail($request->status_id)->title;
    $history = new History([
      'body' => 'Изменен статус с '.$old_status.' на '.$new_status,
      'user_id' => $request->get('user_id'),
      'task_id' => $task->id,
    ]);
    $history->save();
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
