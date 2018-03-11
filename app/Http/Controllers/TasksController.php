<?php

namespace App\Http\Controllers;

use App\Task;
use App\TaskList;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Create new task.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->validate($request, [
           'description' => 'required|max:2000',
        ]);

        $desciption = $request->input('description');
        $listId = $request->input('list_id');

        $list = TaskList::where('id', $listId)->first();

        if($list !== null)
        {
            $created_at = Carbon::now();
            $list->tasks()->create([
                'description' => $desciption,
                'created_at' => $created_at,
                'updated_at' => $created_at,
            ]);

            return back()->with('status', 'You \'ve successfully added new task.');
        }

        return back()->with('error', 'Adding task in a non-existent list.');
    }

    /**
     * Delete task.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::where('id', $id)->first();
        if($task != null)
        {
            $task->delete();
            return redirect('/')->with('status', 'You \'ve successfully deleted the task.');
        }
        return redirect('/');
    }
}
