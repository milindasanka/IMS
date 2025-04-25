@extends('layouts.admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

@section('main-content')
    <!-- teacher profile card -->
    <div class="row">
        <div class="col-lg-12 order-lg-1">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Teacher Account</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="/update_teacher" autocomplete="off">
                        @csrf
                        <h6 class="heading-small text-muted mb-4">Teacher Information</h6>
                        <input type="hidden" value="{{$teacher->id}}" name="id">
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="name">Name</label>
                                        <input type="text" id="name" class="form-control" name="name" placeholder="Name" value="{{$teacher->name}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="emp_no">Employee ID</label>
                                        <input type="text" id="emp_no" class="form-control" placeholder="Employee ID" value="{{$teacher->id}}" disabled>
                                        <input type="hidden" name="emp_no" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="nic">NIC Number</label>
                                        <input type="text" id="nic" class="form-control" name="nic" placeholder="NIC Number" value="{{$teacher->nic}}">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="phone_no">Phone Number</label>
                                        <input type="text" id="phone_no" class="form-control" name="phone_no" placeholder="Phone Number" value="{{$teacher->cnumber}}">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="email">Address</label>
                                        <input type="text" id="email" class="form-control" name="email" placeholder="Email Address" value="{{$teacher->address}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Save Button -->
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col text-center">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="row mt-5">
                        <div class="col-lg-12">
                            <table class="table table-bordered table-striped" id="classy">
                                <thead class="thead-dark">
                                <tr>
                                    <th>Class Name</th>
                                    <th>Total Students</th>
                                    <th>Paid Students</th>
                                    <th>Total Payment</th>
                                    <th>Institute Fee</th>
                                    <th>Net Profit</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($class as $cl)
                                <tr>
                                    <td>{{$cl->class_name}}</td>
                                    <td>{{$cl->student_count}}</td>
                                    <td>{{$cl->paid_student_count}}</td>
                                    <td>Rs {{$cl->paid_student_count * $cl->class_fee }}/=</td>
                                    <td>Rs {{(($cl->paid_student_count * $cl->class_fee)*15)/100 }}/=</td>
                                    <td>Rs {{(($cl->paid_student_count * $cl->class_fee)*85)/100 }}/=</td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>

{{--                    <div class="row mt-5">--}}
{{--                        <div class="col-lg-12">--}}
{{--                            <h4 style="background-color: red; color: white">If you want to delete teacher, click the delete button!</h4>--}}
{{--                            <a href="#"><input class="btn btn-danger" type="button" value="DELETE"></a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#classy').DataTable();
        });
    </script>
@endsection
