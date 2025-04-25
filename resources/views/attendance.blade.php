@extends('layouts.admin')

@section('main-content')

    <div class="container-fluid">
        <h1 class="font-weight-bold">{{$subject->class_name}}</h1>
        <!-- Search Section -->
        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="m-0">Search Student</h5>
            </div>
            <div class="card-body">
                <form class="form-inline" id="search">
                    <div class="form-group mb-2 mr-3">
                        <label for="date" class="mr-2">Date:</label>
                        <input type="text" class="form-control" style="max-width:120px;" name="date" value="{{ date('Y-m-d') }}" readonly>
                    </div>
                    <div class="form-group mb-2">
                        <label for="reg_no" class="mr-2">Reg No:</label>
                        <input type="text" class="form-control" id="reg_no_input" style="min-width: 300px;" name="reg_no" placeholder="Enter Reg No" required autofocus>
                        <input type="hidden" id="class_id" value="{{$id}}"  name="class_id">
                    </div>
                </form>
            </div>
        </div>

        <!-- Student Details -->
        <div class="card shadow mb-4" style="max-width: 600px; margin: 0 auto; border-radius: 10px; overflow: hidden;">
            <div>
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2 d-flex flex-column align-items-center justify-content-center" id="details">

                            <div class="h5 mb-2 font-weight-bold text-gray-800">Waiting to Search Student</div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <!-- Payment & Attendance Mark -->
        <div class="card shadow mb-4">

            <div class="card-body align-self-center">
                <div class="d-flex justify-content-center">
                    <form method="POST" action="/attend" class="me-2">
                        @csrf
                        <input type="hidden" name="reg_no" id="reg_nox" value="">
                        <input type="hidden" name="cid" value="{{$id}}">
                        <button type="submit" class="btn btn-github">Mark Attendance</button>
                    </form>

                    <form method="POST" action="/pay">
                        @csrf
                        <input type="hidden" name="reg_no" id="reg_no" value="">
                        <input type="hidden" name="cid" value="{{$id}}">
                        <button type="submit" id="paybtn" class="btn btn-primary">Pay & Attend</button>
                    </form>
                </div>
            </div>

        </div>

    </div>


    <script>
        $(document).ready(function () {
            $('#reg_no_input').keypress(function (e) {
                if (e.which == 13) {
                    e.preventDefault();
                    let reg_no = $(this).val();
                    let class_id = $('#class_id').val();
                    $.ajax({
                        url: "{{ route('get.detailstu') }}",
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            reg_no: reg_no,
                            class_id: class_id
                        },
                        success: function (data) {
                            let html = '';
                            let statusHtml = '';

                            if (data.pay === 1) {
                                $('#paybtn').prop('disabled', true);
                                statusHtml = `<h1 style="background-color: limegreen; color: white; padding: 5px 20px; border-radius: 5px;">PAID</h1>`;
                            } else {
                                $('#paybtn').prop('disabled', false);
                                statusHtml = `<h1 style="background-color: red; color: white; padding: 5px 20px; border-radius: 5px;">NOT PAID</h1>`;
                            }

                            if (data.reg_no === 0) {
                                html = `<h3 class="text-danger font-weight-bold">Student Not Found!</h3>`;
                            } else {
                                html = `<div class="col mr-2 d-flex flex-column align-items-center justify-content-center">
                                            <div class="h5 mb-2 font-weight-bold text-gray-800">${data.name}</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                ${statusHtml}
                                            </div>
                                        </div>`;
                            }

                            $('#details').html(html);
                            $('#reg_no').val(data.reg_no);
                            $('#reg_nox').val(data.reg_no);
                        },


                        error: function (xhr) {
                            $('#details').html('<div class="text-danger">Error: ' + xhr.responseText + '</div>');
                        }
                    });
                }
            });
        });
    </script>
@endsection
