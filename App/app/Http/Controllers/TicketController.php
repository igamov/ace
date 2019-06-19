<?php

namespace App\Http\Controllers;

use App\Ticket;
use App\User;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $tickets = Ticket::all();
      $tickets->load('project', 'priority', 'status');
      $user_id = $request->user_id;
      $user = User::findOrFail($user_id);
      if ($user) {
        $user_role = $user->role->name;
        switch ($user_role) {
          case 'manager':
            $projects_ids = $user->manager_projects->pluck('id');
            $tickets = $tickets->whereIn('project_id', $projects_ids );
            break;
          case 'customer':
            $tickets = $tickets->where('spokesman_id', $user_id);
            break;
        }
      }
      return response()->json([
        'tickets' => $tickets->toArray()
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
      'body' => 'required',
      'project_id' => 'required|integer',
      'priority_id' => 'required|integer',
      'spokesman_id' => 'required|integer',
    ]);

    $ticket = new Ticket([
      'title' => $request->get('title'),
      'body' => $request->get('body'),
      'project_id' => $request->get('project_id'),
      'priority_id' => $request->get('priority_id'),
      'spokesman_id' => $request->get('spokesman_id'),
      'status_id' => 1
    ]);

    $ticket->save();

    return response()->json($ticket->toArray());
  }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $ticket = Ticket::findOrFail($id);
      $ticket->project = $ticket->project()->with('customer')->get()[0];
      $ticket->load('spokesman', 'priority', 'status');
      return response()->json($ticket);
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
      $ticket = Ticket::findOrFail($id);
      if ($ticket) {
        switch ($request->action) {
          case 'updateStatus':
            $this->validate($request, [
              'status_id' => 'required|max:255',
            ]);
            $ticket->status_id = $request->status_id;
            $ticket->save();

            return response()->json([
              'success' => true,
              'ticket' => $ticket->toArray()
            ]);

            break;
        }
      }else{
        return response()->json([
          'message' => 'Неизвестная ошибка'
        ], 422);
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
