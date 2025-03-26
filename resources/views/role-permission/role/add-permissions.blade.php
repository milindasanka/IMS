@extends('layouts.admin')
@section('main-content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h4> Role Name : {{ $role->name }}
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ url('roles/'.$role->id.'/give-permissions') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            @error('permission')
                            <sp
                            @enderror
                            <label for="">Permissions</label>
                            <div class="row">
                                @foreach($permissions->chunk(5) as $chunk)
                                    <div class="col-md-3"> <!-- Adjust column width as needed -->
                                        @foreach($chunk as $permission)
                                            <label style="display: block;">
                                                <input type="checkbox" name="permission[]" value="{{$permission->name}}" {{ in_array($permission->id, $rolePermissions) ? 'checked':'' }}>
                                                {{ $permission->name }}
                                            </label>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ url('roles') }}" class="btn btn-danger float-end">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
