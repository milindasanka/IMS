@extends('layouts.admin')

@section('main-content')
    @php
        $month = [
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December'];
    @endphp
    <!-- view student -->
    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                CLASS</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$class->class_name}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-bookmark fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                YEAR</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$class->year}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-week fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                TEACHER</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\Teacher::where('id', $class->teacher)->value('name') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-dark shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-dark text-uppercase mb-1 text-center">
                        TUTES LIST</div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>NAME</th>
                                <th>OPEN</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($tute as $tt)
                            <tr>
                                <td>{{$tt->name}}</td>
                                <td><a href="{{ asset('storage/' . $tt->file) }}" target="_blank">
                                    <button class="btn btn-github btn-sm">View</button>
                                </a></td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-dark shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-dark text-uppercase mb-1 text-center">
                        ATTENDANCE LIST</div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>MONTH</th>
                                <th>DATE AND TIME</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($attand as $at)
                            <tr>
                                <td>{{$month[$at->month]}}</td>
                                <td>{{$at->created_at}}</td>
                            </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-dark shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-dark text-uppercase mb-1 text-center">
                        This Year Paid Class Fees</div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>MONTH</th>
                                <th>PAYMENT</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($paid as $pid)
                            <tr>
                                <td>{{$month[$pid->month]}}</td>
                                <td> Rs{{ \App\Models\Classes::where('id', $pid->class_id)->value('fee') }}/=</td>
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
