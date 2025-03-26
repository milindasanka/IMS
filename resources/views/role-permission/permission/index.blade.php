@extends('layouts.admin')
@section('main-content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h4>Permissions
                        <a href="{{ url('permissions/create') }}" class="btn btn-primary float-end">Add Permission</a>
                    </h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Action</th>
                        </thead>
                        <tbody>
                        @foreach($permissions as $permissions)
                            <tr>
                                <td>{{ $permissions->id }}</td>
                                <td>{{ $permissions->name }}</td>
                                <td>
                                    <a href="{{ url('permissions/'.$permissions->id.'/edit') }}" class="btn btn-success ">Edit</a>
                                    <a href="{{ url('permissions/'.$permissions->id.'/delete') }}" class="btn btn-danger">DELETE</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
