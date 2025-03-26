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
    <div class="container mt-12">
        <div class="row">
            <div class="col-md-12">
                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">User Management</h4>
                        <a href="javascript:void(0);"><button class="btn btn-info" data-toggle="modal" data-target="#addUserModal">Add New User</button></a>
                    </div>

                    <div class="card-body">
                        <table id="usersTable" class="table table-bordered table-striped" >
                            <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Role</th>
                                <th>Email</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>
                                        <a href="javascript:void(0);" class="editUser" data-id="{{ $user->id }}" data-name="{{ $user->name }}" data-email="{{ $user->email }}" data-last_name="{{ $user->last_name }}" data-role="{{ $user->roles->first()->id ?? '' }}" data-status="{{ !empty($user->email_verified_at) ? 'active' : 'inactive' }}" style="text-decoration: none; color: inherit;">
                                            {{ $user->name }}
                                        </a>
                                    </td>
                                    <td>
                                        <a href="javascript:void(0);" class="editUser" data-id="{{ $user->id }}" data-name="{{ $user->name }}" data-email="{{ $user->email }}" data-last_name="{{ $user->last_name }}" data-role="{{ $user->roles->first()->id ?? '' }}" data-status="{{ !empty($user->email_verified_at) ? 'active' : 'inactive' }}" style="text-decoration: none; color: inherit;">
                                            {{ $user->last_name }}
                                        </a>
                                    </td>
                                    <td>
                                        <a href="javascript:void(0);" class="editUser" data-id="{{ $user->id }}" data-name="{{ $user->name }}" data-email="{{ $user->email }}" data-last_name="{{ $user->last_name }}" data-role="{{ $user->roles->first()->id ?? '' }}" data-status="{{ !empty($user->email_verified_at) ? 'active' : 'inactive' }}" style="text-decoration: none; color: inherit;">
                                        @if(!empty($user->getRoleNames()))
                                            @foreach($user->getRoleNames() as $rolename)
                                                {{ $rolename }}
                                            @endforeach
                                        @endif
                                        </a>
                                    </td>
                                    <td>
                                        <a href="javascript:void(0);" class="editUser" data-id="{{ $user->id }}" data-name="{{ $user->name }}" data-email="{{ $user->email }}" data-last_name="{{ $user->last_name }}" data-role="{{ $user->roles->first()->id ?? '' }}" data-status="{{ !empty($user->email_verified_at) ? 'active' : 'inactive' }}" style="text-decoration: none; color: inherit;">
                                        {{ $user->email }}
                                        </a>
                                    </td>
                                    <td>
                                        @if(!empty($user->email_verified_at))
                                            <p class="btn btn-success">Active</p>
                                        @else
                                            <p class="btn btn-warning">Inactive</p>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Add user Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userEditModalLabel">Edit User Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addUserForm">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="userName">First Name</label>
                        <input type="text" class="form-control" id="first_namea" name="first_name" required>
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" class="form-control" id="last_names" name="last_name" maxlength="14">
                    </div>
                    <div class="form-group">
                        <label for="userEmail">Email</label>
                        <input type="email" class="form-control" id="emaila" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="userEmail">Password</label>
                        <input type="password" class="form-control" id="passworda" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="userRole">Role Assigned</label>
                        <select class="form-control"  name="rolex">
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="userStatus">Status</label>
                        <select class="form-control" name="status">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-whatsapp" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add User</button>
                </div>
            </form>
        </div>
    </div>
</div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="userEditModal" tabindex="-1" aria-labelledby="userEditModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userEditModalLabel">Edit User Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editUserForm" method="POST" action="{{ url('users/'.$user->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" id="userId" name="user_id">
                        <div class="form-group">
                            <label for="userName">First Name</label>
                            <input type="text" class="form-control" id="userName" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" maxlength="14">
                        </div>
                        <div class="form-group">
                            <label for="userEmail">Email</label>
                            <input type="email" class="form-control" id="userEmail" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="userRole">Role Assigned</label>
                            <select class="form-control" id="userRole" name="role">
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="userStatus">Status</label>
                            <select class="form-control" id="userStatus" name="status">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-whatsapp" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save User</button>
                        <button type="submit" class="btn btn-warning">Reset Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Reset Password Modal -->
    <div class="modal fade" id="resetPasswordModal" tabindex="-1" aria-labelledby="resetPasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="resetPasswordModalLabel">Reset User Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="resetPasswordForm" method="POST" action="{{ url('/passwordreset') }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="resetUserId" name="user_id">
                    <div class="modal-body">
                        <div class="form-group">
                            <h4 style="color: red" id="errorMessage"></h4>
                            <label for="newPassword">New Password</label>
                            <input type="password" class="form-control" id="newPassword" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="confirmPassword">Confirm Password</label>
                            <input type="password" class="form-control" id="confirmPassword" name="password_confirmation" required>
                        </div>
                        <hr>
                        <div class="form-group">
                            <span>Password must meet the following requirements:</span>
                            <ul>
                                <li>must be at least <strong>6 characters</strong></li>
                                <li>must be different from email address</li>
                                <li>must include letters in mixed case and numbers</li>
                                <li>must include <strong>a character</strong> that is not a letter or number</li>
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Reset Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#addUserForm').submit(function(e) {
                e.preventDefault();

                let formData = {
                    first_name: $('#first_namea').val(),
                    last_name: $('#last_names').val(),
                    email: $('#emaila').val(),
                    password: $('#passworda').val(),
                    role: $('select[name="role"]').val(),
                    status: $('select[name="status"]').val(),
                    _token: $('input[name="_token"]').val(),
                };

                $.ajax({
                    url: "{{ route('users.storex') }}",
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            alert('User added successfully!');
                            $('#addUserModal').modal('hide');
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) { // Validation error
                            let errors = xhr.responseJSON.errors;
                            if (errors.email) {
                                alert(errors.email[0]); // Show email error
                            } else {
                                alert('Validation error. Please check your inputs.');
                            }
                        } else {
                            alert('An error occurred. Please try again.');
                        }
                    }
                });
            });
        });

        //models
        $(document).ready(function() {
            $('.editUser').on('click', function() {
                // Get user data from data attributes
                var userId = $(this).data('id');
                var userName = $(this).data('name');
                var userEmail = $(this).data('email');
                var last_name = $(this).data('last_name');
                var userRole = $(this).data('role');
                var userStatus = $(this).data('status');
                // Populate modal fields
                $('#userId').val(userId);
                $('#userName').val(userName);
                $('#userEmail').val(userEmail);
                $('#last_name').val(last_name);
                $('#userRole').val(userRole);
                $('#userStatus').val(userStatus);
                // Show the modal
                $('#userEditModal').modal('show');
            });
        });
        $(document).ready(function() {
            // When the "Reset Password" button is clicked
            $('.btn-warning').on('click', function(event) {
                event.preventDefault(); // Prevent form submission
                // Get user ID from the hidden field and pass it to the reset modal
                var userId = $('#userId').val();
                $('#resetUserId').val(userId);
                $('#userEditModal').modal('hide');
                // Show the reset password modal
                $('#resetPasswordModal').modal('show');
            });
        });
        // Password matching
        document.addEventListener('DOMContentLoaded', function () {
            const password = document.getElementById('newPassword');
            const confirmPassword = document.getElementById('confirmPassword');
            const email = document.getElementById('userEmail');
            const form = document.getElementById('resetPasswordForm');
            const errorMessage = document.getElementById('errorMessage'); // The h1 element for error messages
            form.addEventListener('submit', function (event) {
                const passwordValue = password.value;
                const confirmPasswordValue = confirmPassword.value;
                const emailValue = email.value;
                const regexMixedCase = /(?=.*[a-z])(?=.*[A-Z])/;  // At least one lowercase and one uppercase letter
                const regexNumbers = /(?=.*\d)/; // At least one number
                const regexSpecialChar = /(?=.*[!@#$%^&*(),.?":{}|<>])/; // At least one special character
                const minLength = 6;
                // Function to set error message
                function setErrorMessage(message) {
                    errorMessage.textContent = message;
                    event.preventDefault(); // Prevent form submission
                }
                // 1. Check if passwords match
                if (passwordValue !== confirmPasswordValue) {
                    setErrorMessage('Passwords do not match!');
                    return;
                }
                // 2. Check password length
                if (passwordValue.length < minLength) {
                    setErrorMessage('Password must be at least 6 characters long!');
                    return;
                }
                // 3. Check if password is different from the email
                if (passwordValue.toLowerCase() === emailValue.toLowerCase()) {
                    setErrorMessage('Password must be different from the email address!');
                    return;
                }
                // 4. Check for mixed case letters
                if (!regexMixedCase.test(passwordValue)) {
                    setErrorMessage('Password must include both uppercase and lowercase letters!');
                    return;
                }
                // 5. Check for numbers
                if (!regexNumbers.test(passwordValue)) {
                    setErrorMessage('Password must include at least one number!');
                    return;
                }
                // 6. Check for special character
                if (!regexSpecialChar.test(passwordValue)) {
                    setErrorMessage('Password must include at least one special character!');
                    return;
                }
                // If everything is valid, clear any previous error message
                errorMessage.textContent = '';
            });
        });
    </script>



@endsection
