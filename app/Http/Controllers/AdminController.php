<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TaskList;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('is_admin');
    }

    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $taskLists = TaskList::orderBy('created_at', 'DESC')->get();
        return view('admin.home')->with(['taskLists' => $taskLists]);
    }
}
