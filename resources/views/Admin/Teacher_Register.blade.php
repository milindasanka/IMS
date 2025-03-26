@extends('layouts.admin')
@section('main-content')
    <h1>Teacher Register</h1>
    <div class="col-xl-8 col-md-6 mb-8">
        <div class="card shadow mb-4">
            <div class="card-body">
                <form method="POST" action="/Teacher_Register">
                    @csrf
                    <div class="form-group">
                        <label for="title">Full NAME :</label>
                        <input type="text" class="form-control" name="name" >
                    </div>
                    <div class="form-group">
                        <label for="title">NIC Number :</label>
                        <input type="text" class="form-control" name="nic" >
                    </div>
                    <div class="form-group">
                        <label for="title">Home Address :</label>
                        <input type="text" class="form-control" name="address" >
                    </div>
                    <div class="form-group">
                        <label for="title">Contact Number :</label>
                        <input type="tel" class="form-control" name="cnumber" >
                    </div>
                    <div class="form-group">
                        <label for="title">Email :</label>
                        <input type="email" class="form-control" name="email" >
                    </div>
                    <div class="form-group">
                        <label for="title">Password :</label>
                        <input type="password" class="form-control" name="pw" >
                    </div>
        <div class="form-group">
            <input type="submit" class="form-control btn btn-success"  value="Register Teacher">
        </div>
        </form>
    </div>
@endsection
