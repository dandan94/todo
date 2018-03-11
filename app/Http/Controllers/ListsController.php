<?php

namespace App\Http\Controllers;

use App\TaskList;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        $taskLists = TaskList::orderBy('created_at', 'DESC')->get();

        return view('home')->with(['taskLists' => $taskLists]);
    }

    /**
     * Show the tasks in the list.
     *
     * @param $id     List id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $taskList = TaskList::where('id', $id)->first();
        return view('single-list')->with(['list' => $taskList]);
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

        TaskList::create([
            'name' => $name,
            'created_at' => $created_at,
            'updated_at' => $created_at,
        ]);

        return redirect('/')->with('status', 'You \'ve successfully created new list.');
    }

    public function archive()
    {
        
    }

    public function destroy($id)
    {
        $list = TaskList::where('id', $id)->first();
        if($list != null)
        {
            $list->delete();
            return redirect('/')->with('status', 'You \'ve successfully deleted the list of tasks.');
        }
        return redirect('/');
    }
}
