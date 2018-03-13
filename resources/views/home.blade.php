@extends('layouts.app')

@section('content')
    <div class="card">
                <div class="card-header">Lists</div>

                <div class="card-body">
                    @include('inc.status_msg')
                    @if($errors->has('name'))
                        <div class="alert alert-danger">
                            <strong>{{ $errors->first('name') }}</strong>
                        </div>
                    @endif
                    <form action="{{ action('ListsController@create') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-10 col-sm-8"><input type="text" class="form-control" name="name"></div>
                            <div class="col-md-2 col-sm-2"><button class="btn btn-primary" type="submit">Add</button></div>
                        </div>
                    </form>
                    <ul class="list-group p-2">
                        @forelse($taskLists as $taskList)
                            <li class="list-group-item">
                                <a href="{{ action('ListsController@show', $taskList->id)  }}">{{ $taskList->name }}</a>
                                <div class="float-right">
                                    @if($taskList->to_delete == 0)
                                        <div class="float-right">
                                            <form action="{{ action('ListsController@destroy', $taskList->id) }}" method="post">
                                                @csrf
                                                <input type="hidden" name="_method" value="delete">
                                                <button class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </div>
                                    @else
                                        <button disabled class="btn btn-danger btn-sm">Delete</button>
                                    @endif
                                    <div class="float-right mr-2">
                                        @if($taskList->tasks()->get()->count() > 0 && $taskList->is_archived == 0)
                                            <form action="{{ action('ListsController@archive', $taskList->id) }}" method="post">
                                                @csrf
                                                <button class="btn btn-dark btn-sm">Archive</button>
                                            </form>

                                        @elseif($taskList->is_archived == 1)
                                            <span class="text-muted">Archived</span>
                                        @endif
                                    </div>
                                </div>
                            </li>
                        @empty
                            <div class="alert alert-info">There are no tasks at the moment.</div>
                        @endforelse
                    </ul>
                </div>
            </div>
@endsection
