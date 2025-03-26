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
                        <button class="btn btn-info" data-toggle="modal" data-target="#addUserModal">Add New User</button>
                    </div>

                    <div class="card-body">
                        <table id="usersTable" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>NIC</th>
                                <th>Stream</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody id="usersBody">
                            <!-- Data will be inserted here via AJAX -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="userEditModal" tabindex="-1" aria-labelledby="userEditModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userEditModalLabel">Student Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editUserForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" id="userId" name="user_id">

                        <div class="form-group">
                            <label for="Name">Name</label>
                            <input type="text" class="form-control" id="Name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="Address">Address</label>
                            <input type="text" class="form-control" id="Address" name="address">
                        </div>
                        <div class="form-group">
                            <label for="NIC">NIC</label>
                            <input type="text" class="form-control" id="NIC" name="nic" required>
                        </div>
                        <div class="form-group">
                            <label for="Email">Email</label>
                            <input type="email" class="form-control" id="Email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="cNumber">Contact Number</label>
                            <input type="text" class="form-control" id="cNumber" name="cnumber" required>
                        </div>
                        <div class="form-group">
                            <label for="hNumber">Home Number</label>
                            <input type="text" class="form-control" id="hNumber" name="homenumber" required>
                        </div>
                        <div class="form-group">
                            <label for="Stream">Stream</label>
                            <input type="text" class="form-control" id="Stream" name="stream" required>
                        </div>
                        <div class="form-group">
                            <label for="Year">Year</label>
                            <input type="text" class="form-control" id="Year" name="year" required>
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
                        <button type="submit" class="btn btn-primary">Save User</button>
                        <button type="button" class="btn btn-warning">Reset Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            fetchUsers(); // Fetch users on page load

            function fetchUsers() {
                $.ajax({
                    url: "/student-list", // Laravel route to fetch users
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        var rows = "";
                        $.each(data, function(index, user) {
                            var statusClass = user.status ? "btn-success" : "btn-warning";
                            var statusText = user.status ? "Active" : "Inactive";

                            rows += `
                        <tr>
                            <td>
                                <a href="javascript:void(0);" class="editUser"
                                   data-id="${user.id}"
                                   data-name="${user.name}"
                                   data-address="${user.address}"
                                   data-nic="${user.nic}"
                                   data-email="${user.email}"
                                   data-cnumber="${user.cnumber}"
                                   data-homenumber="${user.homenumber}"
                                   data-stream="${user.stream}"
                                   data-year="${user.year}"
                                   data-status="${user.status ? 'active' : 'inactive'}">
                                   ${user.name}
                                </a>
                            </td>
                            <td>${user.email}</td>
                            <td>${user.nic}</td>
                            <td>${user.stream}</td>
                            <td><p class="btn ${statusClass}">${statusText}</p></td>
                        </tr>
                    `;
                        });
                        $("#usersBody").html(rows);
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching users:", error);
                    }
                });
            }

            // Use event delegation to handle dynamically added elements
            $(document).on('click', '.editUser', function() {
                // Get user data from data attributes
                var userId = $(this).data('id');
                var name = $(this).data('name');
                var address = $(this).data('address');
                var nic = $(this).data('nic');
                var email = $(this).data('email');
                var cNumber = $(this).data('cnumber');
                var hNumber = $(this).data('homenumber');
                var stream = $(this).data('stream');
                var year = $(this).data('year');
                var userStatus = $(this).data('status');

                console.log("Editing user:", name); // Debugging log

                // Populate modal fields
                $('#userId').val(userId);
                $('#Name').val(name);
                $('#Address').val(address);
                $('#NIC').val(nic);
                $('#Email').val(email);
                $('#cNumber').val(cNumber);
                $('#hNumber').val(hNumber);
                $('#Stream').val(stream);
                $('#Year').val(year);
                $('#userStatus').val(userStatus);

                // Show the modal
                $('#userEditModal').modal('show');
            });
        });


    </script>


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
