@extends('layouts.app')

@section('content')
    <h2>Admin panel</h2>
    @include('inc.status_msg')
    <div class="card">
        <div class="card-header">User lists</div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <th>#</th>
                    <th>List name</th>
                    <th>Actions</th>
                </thead>
                <tbody>
                    @foreach($taskLists as $taskList)
                        <tr>
                            <td></td>
                            <td>{{ $taskList->name }}</td>
                            <td>
                                @if($taskList->to_delete == 1)
                                    <form action="{{ action('ListsController@delete', $taskList->id) }}" method="post">
                                        @csrf
                                        <input type="hidden" name="_method" value="delete">
                                        <button class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection