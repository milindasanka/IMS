@extends('layouts.admin')
@section('main-content')
    <h1>Class Register</h1>

    <div class="col-xl-8 col-md-6 mb-8">
        <div class="card shadow mb-4">
            <div class="card-body">
                <form method="POST" action="/Class_Register">
                    @csrf
                    <div class="form-group">
                        <label for="title">SELECT STREAM :</label>
                        <select id="stream" name="stream" class="form-control">
                            <option value="" selected disabled>Select Your Stream</option>
                            <option>Arts</option>
                            <option>Commerce</option>
                            <option>Bio Stream</option>
                            <option>Maths Stream</option>
                            <option>Tech Stream</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="title">SUBJECT NAME :</label>
                        <input type="text" class="form-control" name="subject" >
                    </div>
                    <div class="form-group"><label for="exampleFormControlInput1">TEACHER :</label>
                        <select class="form-control" name="teacher" id="exampleFormControlSelect1">
                            @foreach($teachers as $teacher)
                                <option VALUE="{{$teacher->id}}">{{$teacher->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group"><label for="exampleFormControlInput1">AL YEAR :</label>
                        <input class="form-control" id="exampleFormControlInput1" name="year" type="number" placeholder="AL YEAR">
                        <span style="color: red">@error('year'){{$message}}@enderror</span>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">SELECT CLASS TYPE</label>
                        <select class="form-control" name="type" id="exampleFormControlSelect1">
                            <option VALUE="">SELECT CLASS TYPE</option>
                            <option VALUE="THEORY">Theory</option>
                            <option VALUE="REVISION">Revision</option>
                        </select>
                    </div>
                    <div class="form-group"><label for="exampleFormControlInput1">CLASS FEE :</label>
                        <input class="form-control" id="exampleFormControlInput1" name="fee" type="number" placeholder="Fee of class">
                        <span style="color: red">@error('fee'){{$message}}@enderror</span>
                    </div>
            </div>
        </div>
        <div class="form-group">
            <input type="submit" class="form-control btn-success" id="exampleFormControlInput1"  value="ADD CLASS">
        </div>
        </form>
    </div>
@endsection
