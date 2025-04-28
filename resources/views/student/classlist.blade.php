@extends('layouts.admin')

@section('main-content')
    <style>
        .dataTables_wrapper .dataTables_filter {
            float: right;
            text-align: left;
        }
        .dataTables_wrapper .dataTables_paginate {
            float: right;
            text-align: left;
        }
    </style>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Class List</h4>
                    </div>

                    <div class="card-body">
                        <table id="stTable" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Teacher</th>
                                <th>Fee</th>
                                <th>Stream</th>
                                <th>Type</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($classlist as $st)
                                <tr>
                                    <td>{{ $st->class_name }}</td>
                                    <td>{{ \App\Models\Teacher::where('id', $st->teacher)->value('name') }}</td>
                                    <td>{{ $st->fee }}</td>
                                    <td>{{ $st->stream }}</td>
                                    <td>{{$st->type}}</td>
                                    <td>
                                        <a href="/stclases-view/{{$st->id}}"><button class="btn btn-info">View</button></a>
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

    <script>
        $(document).ready(function() {
            $('#stTable').DataTable();
        });
    </script>


@endsection
