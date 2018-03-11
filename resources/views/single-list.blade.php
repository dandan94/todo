@extends('layouts.app')

@section('content')
    @include('inc.status_msg')
    @if($errors->has('description'))
        <div class="alert alert-danger">{{ $errors->first('description') }}</div>
    @endif
    <div class="card">
        <div class="card-header">
            List "{{ $list->name }}"
            <div class="float-right"><button class="btn btn-sm" data-toggle="modal" data-target="#addNewTaskModal">Add</button></div>
        </div>
        <div class="card-body">
            <ul class="list-group">
                @foreach($list->tasks as $task)
                    <li class="list-group-item">
                        <input type="checkbox" /> {{ $task->description }}
                        <div class="float-right"><button class="btn btn-danger btn-sm">Delete</button></div>
                    </li>
                @endforeach
            </ul>
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