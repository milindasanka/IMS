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
                        <h4 class="mb-0">Students List</h4>
                        <a href="{{ url('/Student_Register') }}" class="btn btn-info">Student Register</a>
                    </div>

                    <div class="card-body">
                        <table id="stTable" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>NIC</th>
                                <th>Stream</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($students as $st)
                                <tr>
                                    <td>{{ $st->name }}</td>
                                    <td>{{ $st->email }}</td>
                                    <td>{{ $st->nic }}</td>
                                    <td>{{ $st->stream }}</td>
                                    <td>
                                        @if($st->status === 1)
                                            <span class="badge bg-success text-white">Active</span>
                                        @else
                                            <span class="badge bg-danger text-white">Inactive</span>
                                        @endif
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
