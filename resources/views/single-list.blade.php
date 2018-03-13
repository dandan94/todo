@extends('layouts.app')

@section('content')
    @include('inc.status_msg')
    @if($errors->has('description'))
        <div class="alert alert-danger">{{ $errors->first('description') }}</div>
    @endif
    <div class="card">
        <div class="card-header">
            List "{{ $list->name }}"
            <div class="float-right">
                <form action="{{ action('ListsController@exportToXls', $list->id) }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-sm">Export</button>
                </form>
            </div>
            <div class="float-right mr-4">
                <button class="btn btn-sm" data-toggle="modal" data-target="#addNewTaskModal">Add</button>
            </div>

            <div class="float-right mr-4">
                <form action="{{ action('ListsController@show', $list->id) }}" method="get" name="updateStatusForm">
                    <select class="form-control" onchange="this.form.submit();" method="get" name="status">
                        <option value="all" {{ app('request')->input('status') == 'all' ? 'selected' : '' }} >All</option>
                        <option value="open" {{ app('request')->input('status') == 'open' ? 'selected' : '' }} >Open</option>
                        <option value="closed" {{ app('request')->input('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                        <option value="paused" {{ app('request')->input('status') == 'paused' ? 'selected' : '' }}>Paused</option>
                    </select>
                </form>
            </div>
        </div>
        <div class="card-body">

            @if($tasks->count() > 0)
            <table class="table table-bordered">
                <thead>
                    <th>#</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Date added</th>
                    <th>Actions</th>
                </thead>
                <tbody>
                    @foreach($tasks as $task)
                        <tr>
                            <td></td>
                            <td>{{ $task->description }}</td>
                            <td>
                                <form action="{{ action('TasksController@update') }}" method="post" name="updateStatusForm">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $task->id }}">
                                    <select class="form-control" onchange="this.form.submit();" name="status" id="status-select-{{ $task->id }}">
                                        <option value="open" {{ $task->status == 'open' ? 'selected' : '' }} >Open</option>
                                        <option value="closed" {{ $task->status == 'closed' ? 'selected' : '' }}>Closed</option>
                                        <option value="paused" {{ $task->status == 'paused' ? 'selected' : '' }}>Paused</option>
                                    </select>
                                </form>
                            </td>
                            <td>{{ date('d M Y', $task->created_at->timestamp) }}</td>
                            <td><button class="btn btn-danger btn-sm">Delete</button></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @else
                <div class="alert alert-info">No tasks in this list.</div>
            @endif
        </div>
    </div>
    <div class="modal fade" id="addNewTaskModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add new task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ action('TasksController@create')  }}" name="addNewTaskForm" method="post">
                        @csrf
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description" id="description" cols="30" rows="10"></textarea>
                        <input type="hidden" name="list_id" value="{{ $list->id }}">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="document.addNewTaskForm.submit();" class="btn btn-primary">Add</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection