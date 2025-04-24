@extends('layouts.admin')

@section('main-content')
    <div class="container-fluid">
        <!-- Class Details -->
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body d-flex align-items-center">
                        <div class="mr-auto">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Subject</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$class->subject}}</div>
                        </div>
                        <i class="fas fa-bookmark fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body d-flex align-items-center">
                        <div class="mr-auto">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Year</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$class->year}}</div>
                        </div>
                        <i class="fas fa-calendar-week fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body d-flex align-items-center">
                        <div class="mr-auto">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Teacher</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\Teacher::where('id', $class->teacher)->value('name') }}</div>
                        </div>
                        <i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Class Stats -->
        <div class="row">
            <div class="col-md-7 mb-4">
                <div class="card shadow h-100 py-3 px-3">
                    <h6 class="text-uppercase text-secondary font-weight-bold mb-3">Class Statistics</h6>
                    <div class="row text-center">
                        <div class="col-md-4 mb-3">
                            <h3 class="text-primary font-weight-bold">{{ $studentData->count() }}</h3>
                            <p class="text-muted">Registered</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <h3 class="text-primary font-weight-bold">{{$paymentcount}}</h3>
                            <p class="text-muted">Paid Students</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <h3 class="text-primary font-weight-bold">{{$class->fee}}/=</h3>
                            <p class="text-muted">Class Fee</p>
                        </div>
                    </div>
                    <div class="row text-center mt-4">
                        <div class="col-md-4 mb-3">
                            <h4 class="text-success font-weight-bold">{{$paymentcount * $class->fee}}/=</h4>
                            <p class="text-muted">Total Paid</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <h4 class="text-success font-weight-bold">{{(($paymentcount * $class->fee) * 15) / 100}}/=</h4>
                            <p class="text-muted">Institute Fee</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <h4 class="text-success font-weight-bold">{{(($paymentcount * $class->fee) * 85) / 100}}/=</h4>
                            <p class="text-muted">Net Profit</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add Tute -->
            <div class="col-md-5 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <h6 class="text-uppercase text-success font-weight-bold mb-3">Add Tute</h6>
                        <form method="POST" action="{{ url('class_view/addtute') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="tute_name">Tute Name:</label>
                                <input type="text" class="form-control" id="tute_name" name="tute_name" placeholder="Enter Tute Name" required>

                                <input type="hidden" name="class_id" value="{{$class->id}}"> <!-- You can pass the class ID dynamically if needed -->
                            </div>

                            <div class="form-group mt-3">
                                <label for="tute">Upload Tute:</label>
                                <input type="file" class="form-control" id="tute" name="tute" required>
                            </div>

                            <button type="submit" class="btn btn-success mt-3">Add Tute</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 mb-4">
                <div class="card border-left-dark shadow h-100 py-3 px-3">
                    <h6 class="text-uppercase text-dark font-weight-bold mb-3">Tutes List</h6>
                    <table class="table table-bordered table-hover">
                        <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tutes as $list)
                        <tr>
                            <td>{{$list->id}}</td>
                            <td>{{$list->name}}</td>
                            <td>{{$list->created_at}}</td>
                            <td>
                                <a href="{{ asset('storage/' . $list->file) }}" target="_blank">
                                    <button class="btn btn-github btn-sm">View</button>
                                </a>
                                <form action="{{ url('/deletetute/' . $list->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this tute?');" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Student List -->
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card border-left-dark shadow h-100 py-3 px-3">
                    <h6 class="text-uppercase text-dark font-weight-bold mb-3">Student List</h6>
                    <table class="table table-bordered table-hover">
                        <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Contact</th>
                            <th>Home Number</th>
                            <th>Attendance</th>
                            <th>Paid</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($studentData as $llis)
                        <tr>
                            <td>{{$llis->id}}</td>
                            <td>{{$llis->name}}</td>
                            <td>{{$llis->cnumber}}</td>
                            <td>{{$llis->homenumber}}</td>
                            <td>85%</td>
                            @if(\App\Models\Payemnt::where('student_id', $llis->id)->exists())
                                <td class="bg-success">NOT PAID</td>
                            @else
                                <td class="bg-secondary">PAID</td>
                            @endif
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
