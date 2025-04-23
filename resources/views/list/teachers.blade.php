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
                        <h4 class="mb-0">Teachers List</h4>
                        <a href="{{ url('/Teacher_Register') }}" class="btn btn-info">Teacher Register</a>
                    </div>

                    <div class="card-body">
                        <table id="stTable" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>NIC</th>
                                <th>Address</th>
                                <th>Contact</th>
                                <th>Email</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($teachers as $st)
                                <tr>
                                    <td>{{ $st->name }}</td>
                                    <td>{{ $st->nic }}</td>
                                    <td>{{ $st->address }}</td>
                                    <td>{{ $st->cnumber }}</td>
                                    <td>{{$st->email}}</td>
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
