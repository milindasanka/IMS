@extends('layouts.admin')

@section('main-content')


<form method="POST" action="{{ route('class.update', $class->id) }}">
    @csrf
    @method('PUT')

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Class</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <label for="stream">Stream</label>
                    <input type="text" name="stream" class="form-control" value="{{ $class->stream }}" disabled>
                </div>
                <input type="hidden" value="{{$class->id}}" name="id">
                <div class="col-md-6">
                    <label for="class_name">Class Name</label>
                    <input type="text" name="class_name" class="form-control" value="{{ $class->class_name }}" disabled>
                </div>
                <div class="col-md-6 mt-3">
                    <label for="subject">Subject</label>
                    <input type="text" name="subject" class="form-control" value="{{ $class->subject }}" disabled>
                </div>
                <div class="col-md-6 mt-3">
                    <label for="teacher">Teacher</label>
                    <input type="text" name="teacher" class="form-control" value="{{ \App\Models\Teacher::where('id', $class->teacher)->value('name') }}" disabled>
                </div>
                <div class="col-md-6 mt-3">
                    <label for="year">Year</label>
                    <input type="text" name="year" class="form-control" value="{{ $class->year }}" disabled>
                </div>
                <div class="col-md-6 mt-3">
                    <label for="type">Type</label>
                    <input type="text" name="type" class="form-control" value="{{ $class->type }}" disabled>
                </div>
                <div class="col-md-6 mt-3">
                    <label for="fee">Fee</label>
                    <input type="text" name="fee" class="form-control" value="{{ $class->fee }}" required>
                </div>
                <div class="col-md-6 mt-3">
                    <label for="status">Status</label>
                    <select name="status" class="form-control">
                        <option value="1" {{ $class->status ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ !$class->status ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>

            <div class="mt-4 text-center">
                <button type="submit" class="btn btn-primary">Update Class</button>
            </div>
        </div>
    </div>
</form>
@endsection
