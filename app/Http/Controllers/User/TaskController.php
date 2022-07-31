<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\addTaskFormRequest;
use App\Http\Requests\Task\updateTaskFormRequest;
use App\Models\Comment;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $task = Task::with('users')->get();
        return view('Task.assignedOther', ['task' => $task]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::where('id', '!=', Auth::guard('user')->id())->get();
        return view('Task.addNewTask', ['users' => $user]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(addTaskFormRequest $request)
    {
        try {
            Task::create([
                'assigned_by' => Auth::guard('user')->user()->id,
                'title' => $request->title,
                'description' => $request->description,
                'due_date' => $request->deadline,
            ])->users()->attach($request->emp);
            return redirect()->route('user.Dashboard')->with('success', 'Task Assigned Successfully');
        } catch (\Exception $exception) {
            dd($exception);
            return redirect()->back()->with('error', 'Temporary Server Error.');
        }
    }

    /**
     * Get Comment
     */
    public function getComment($id)
    {
        $user = Auth::guard('user')->user();
        $comment = Comment::where('task_id', $id)->with(['user', 'task'])->orderBy('created_at', 'desc')->get();
        return response()->json(['comment' => $comment, 'users' => $user]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tasks = Task::with('users')->find($id);
        $comment = Comment::where('task_id', $id)->orderBy('created_at', 'desc')->get();
        // just for reference👇👇
        // $comment = Comment::where('task_id', $id)->whereHas('task', function ($q) {
        //     return $q->where('due_date', '>=', Carbon::now()->toDateString());
        // })->orderBy('created_at', 'desc')->get();

        return view('Task.taskDetails', ['tasks' => $tasks, 'user' => Auth::guard('user')->user()->id, 'comments' => $comment]);
    }

    public function newComment(Request $request)
    {
        try {
            Comment::create([
                'user_id' => $request->userId,
                'task_id' => $request->taskId,
                'comment' => $request->comment,
            ]);
            return response()->json('success');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', 'Temporary Server Error.');
        }
    }

    public function updateComment(Request $request)
    {
        try {
            Comment::where('id', $request->cmntId)->update([
                'comment' => $request->comment,
            ]);
            return response()->json(['success', 'Comment Updated']);
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', 'Temporary Server Error.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $task = Task::with('users')->find($id);
        $user = User::where('id', '!=', Auth::guard('user')->id())->get();
        return view('Task.updateTask', ['users' => $user, 'tasks' => $task]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(updateTaskFormRequest $request, $id)
    {
        try {
            $task_update = Task::where('id', $id)->first();
            $task_update->update([
                'title' => $request->title,
                'description' => $request->description,
                'due_date' => $request->deadline,
            ]);
            $task_update->users()->sync($request->emp);
            return redirect()->route('task.show', ['task' => $id])->with('success', 'Task Updated');
        } catch (\Exception $exception) {
            dd($exception);
            return redirect()->back()->with('error', 'Temporary Server Error.');
        }
    }

    public function overDue()
    {
        // dd(Carbon::now()->toDateString());
        $task = Task::where('due_date', '<', Carbon::now()->toDateString())->with('users')->get();
        return view('Task.overDueTasks', ['task' => $task]);
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
