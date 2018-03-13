<?php

namespace App\Http\Controllers;

use App\TaskList;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;

class ListsController extends Controller
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
     * Show the lists.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id = null)
    {
        $taskLists = TaskList::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->get();

        return view('home')->with(['taskLists' => $taskLists]);
    }

    /**
     * Show the tasks in the list.
     *
     * @param $id     List id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $taskList = TaskList::where('id', $id)->first();
        $tasks = $taskList->tasks()->get();

        $status = $request->input('status');
        if($status !== null && in_array($status, ['open', 'closed', 'paused']))
        {
            $tasks = $taskList->tasks()->where('status', $status)->get();
        }

        return view('single-list')->with(['list' => $taskList, 'tasks' => $tasks]);
    }

    /**
     * Create new list.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);
        $name = $request->input('name');
        $created_at = Carbon::now();

        $user = Auth::user();

        $user->lists()->create([
            'name' => $name,
            'created_at' => $created_at,
            'updated_at' => $created_at,
        ]);

        return redirect('/')->with('status', 'You \'ve successfully created new list.');
    }

    public function exportToXls($id)
    {
        $list = TaskList::where('id', $id)->first();

        if($list !== null)
        {
            $excel = \App::make('excel');

            $tasks = $list->tasks();

            $tasksArray = ['id', 'list_id', 'description', 'status', 'created_at', 'updated_at'];

            foreach ($tasks as $task) {
                $tasksArray[] = $task->toArray();
            }

            $excel->create('tasks', function($excel) use ($tasksArray) {

                // Set the spreadsheet title, creator, and description
                $excel->setTitle('Tasks');
                $excel->setCreator(Auth::user()->name)->setCompany('Test company');
                $excel->setDescription('Tasks from list');

                // Build the spreadsheet, passing in the payments array
                $excel->sheet('sheet1', function($sheet) use ($tasksArray) {
                    $sheet->fromArray($tasksArray, null, 'A1', false, false);
                });

            })->download('xlsx');

            return back();
        }
    }

    public function archive($id)
    {
        $list = TaskList::where('id', $id)->first();
        if($list != null)
        {
            $list->is_archived = 1;
            $list->save();
            return redirect('/')->with('status', 'You \'ve successfully archived this list.');
        }
        return redirect('/');
    }

    public function delete($id)
    {
        $this->middleware('is_admin');
        $list = TaskList::where('id', $id)->first();
        if($list != null)
        {
            $list->delete();
            return redirect('/admin')->with('status', 'You \'ve deleted the list.');
        }
        return redirect('/admin');
    }

    public function destroy($id)
    {
        $list = TaskList::where('id', $id)->first();
        if($list != null)
        {
            $list->to_delete = 1;
            $list->save();
            return redirect('/')->with('status', 'You \'ve successfully added this list for deleteion. Admin will review it and delete it eventually.');
        }
        return redirect('/');
    }
}
