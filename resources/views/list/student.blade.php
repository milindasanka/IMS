@extends('layouts.admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
@section('main-content')

    <!-- student profile card -->
    <div class="row">
        <div class="col-lg-4 order-lg-2">
            <div class="card shadow mb-4">
                <div class="card-profile-image mt-4">
                    <div class="visible-print text-center">
                        <div align="center">
                            {!! $qr !!}
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-center">
                                <h5 class="font-weight-bold">{{$student->name}}</h5>
{{--                                <a href="#"><input type="button" class="btn btn-success" value="VIEW ID"></a>--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8 order-lg-1">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Student Account</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="/update-student" autocomplete="off">
                        @csrf
                        <h6 class="heading-small text-muted mb-4">Student information</h6>

                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="name">Name</label>
                                        <input type="text" id="name" class="form-control" name="name" placeholder="Name" value="{{$student->name}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <input type="hidden" name="id" value="{{$student->id}}">
                                        <label class="form-control-label" for="reg_no">Register NO</label>
                                        <input type="text" id="reg_no" class="form-control"  placeholder="Register No" value="{{$student->id}}" disabled>
                                        <input type="hidden" name="reg_no" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="nic">NIC NO</label>
                                        <input type="text" id="nic" class="form-control" name="nic" placeholder="NIC Number" value="{{$student->nic}}">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="phone_no">Phone NO</label>
                                        <input type="text" id="phone_no" class="form-control" name="phone_no" placeholder="Phone Number" value="{{$student->cnumber}}">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="home_no">Home NO</label>
                                        <input type="text" id="home_no" class="form-control" name="home_no" placeholder="Home Number" value="{{$student->homenumber}}">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="stream_name">Stream</label>
                                        <input type="text" id="stream_name" class="form-control" name="stream_name" placeholder="Stream" value="{{$student->stream}}" readonly>
                                        <input type="hidden" name="stream" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="address">Address</label>
                                        <input type="text" id="address" class="form-control" name="address" placeholder="Address" value="{{$student->address}}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Button -->
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col text-center">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <form action="/addclassstr" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <div class="alert alert-danger show-error-message" style="display:none">
                                    <ul></ul>
                                </div>
                                <div class="alert alert-success show-success-message" style="display:none">
                                    <ul></ul>
                                </div>
                                <div class="table-responsive">
                                    <label for="title"><b>ADD MORE CLASSES</b></label>
                                    <input type="hidden" name="id" value="{{$student->id}}">
                                    <select name="class" id="class" class="select2" multiple="multiple" data-placeholder="Select Classes" data-dropdown-css-class="select2-purple" style="width: 100%;">
                                        @foreach($class as $cl)
                                        <option value="{{$cl->id}}">{{$cl->class_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <br>
                                <input type="submit" class="btn btn-success" value="Add class">
                                <br>
                    </form>
                    <br>
                    <div class="col-lg-8">
                        <table style="border:1px;" class="table table-bordered">
                            <th>Student Classes</th>
                            <th>Action</th>
                            @foreach($stclasslist as $clsi)
                            <tr>
                                <td><b>{{$clsi->class_name}}</b></td>
                                <td>
                                    <form action="{{ route('stclasses.destroy', $clsi->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this class?');">
                                        @csrf
                                        <input type="hidden" value="{{$student->id}}" name="student_id">
                                        @method('DELETE')

                                        <button type="submit" style="color: red; border: none; background: none; cursor: pointer;">DELETE</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>&nbsp;

                <div class="row">
                    <div class="col-lg-12">
                        <h4 style="background-color: red; color: white">If you want delete student click here delete button!</h4>
                        <a href="/deletestudent/{{$student->id}}"><input class="btn btn-danger" type="button" value="DELETE "></a>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
