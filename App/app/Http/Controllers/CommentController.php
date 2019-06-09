<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param int $task_id
     * @return \Illuminate\Http\Response
     */
  public function index($task_id)
  {
    return response()->json($task_id);
//    $comments = Comment::where('task_id', $task_id)->get();
//
//    return response()->json([
//      'comments' => $comments->toArray()
//    ]);

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
      'body' => 'required',
    ]);
    $comment = new Comment([
      'body' => $request->get('body'),
      'task_id' => $request->get('task_id'),
      'user_id' => 1,
    ]);

    $comment->save();

    return response()->json($comment->toArray());
  }

  /**
   * Display the specified resource.
   *
   * @param  int $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $comment = Comment::findOrFail($id);
    return response()->json($comment);
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
    $comment = Comment::findOrFail($id);
    $comment->update($request->all());
    return response()->json($comment->toArray());
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $comment = Comment::findOrFail($id);
    $comment->delete();
    return response()->json('Successfully Deleted');
  }
}
