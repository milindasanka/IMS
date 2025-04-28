@extends('layouts.admin')

@section('main-content')

    @if (session('success'))
    <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if (session('status'))
        <div class="alert alert-success border-left-success" role="alert">
            {{ session('status') }}
        </div>
    @endif


    <div class="row">
        @can('student')
            <div class="text-center my-5">
                <h1 class="display-4 font-weight-bold text-primary" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.2);">
                    Welcome, Student! 🎓
                </h1>
                <p class="lead text-muted mt-3">
                    Wishing you a wonderful learning journey!
                </p>
            </div>
        @endcan
        @can('teacher')
            <div class="text-center my-5">
                <h1 class="display-4 font-weight-bold text-success" style="text-shadow: 1px 1px 3px rgba(0,0,0,0.2);">
                    Welcome, Teacher! 👩‍🏫👨‍🏫
                </h1>
                <p class="lead text-muted mt-3">
                    Inspire, educate, and empower your students!
                </p>
            </div>
            @endcan
        @can('manage users')
        <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-danger shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                        STUDENTS
                                    </div>
                                    <div class="h1 font-weight-bold text-info">{{ $widget['students'] }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user-graduate fa-3x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Paid Students -->
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Classes
                                    </div>
                                    <div class="h1 font-weight-bold text-success">{{ $widget['class'] }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-school-circle-check fa-3x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Participants -->
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        TEACHERS
                                    </div>
                                    <div class="h1 font-weight-bold text-primary">{{ $widget['teachers'] }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-chalkboard-teacher fa-3x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    </div>

    <!-- Class Details Table -->
    <div class="row">
        <div class="col-xl-12 col-md-6 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <h4 class="text-primary font-weight-bold mb-3">Class Details</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="thead-dark">
                            <tr>
                                <th>CLASS ID</th>
                                <th>SUBJECT</th>
                                <th>YEAR</th>
                                <th>TEACHER</th>
                                <th>REGISTERED</th>
                                <th>PAID</th>
                                <th>PARTICIPANT</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($list as $li)
                            <tr>
                                <td>{{$li->id}}</td>
                                <td>{{$li->subject}}</td>
                                <td>{{$li->year}}</td>
                                <td>{{ \App\Models\Teacher::where('id', $li->teacher)->value('name') }}</td>
                                <td>{{ \App\Models\StudentClass::where('class_id', $li->id)->count() }}</td>
                                <td>{{ \App\Models\Payemnt::where('class_id', $li->id)->where('month', now()->month)->count() }}</td>
                                <td>{{ \App\Models\Attendance::where('class_id', $li->id)->where('month', now()->month)->count() }}</td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        @endcan

    </div>

@endsection
