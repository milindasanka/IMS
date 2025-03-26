@extends('layouts.admin')
@section('main-content')

    <h1>Student Register</h1>

   <div class="row">
       <div class="col-lg-12 mb-4">
           <!--form-->
           <div class="card shadow mb-4">
               <div class="card-body">
                   <form method="POST" action="/Student_Register">
                       @csrf
                       <div class="form-group"><label for="exampleFormControlInput1">FULL NAME :</label>
                           <input class="form-control" id="exampleFormControlInput1" name="student_name" type="text" placeholder="Enter Student Name">
                           <span style="color: red">@error('student_name'){{"$message"}}@enderror</span>
                       </div>
                       <input type="hidden" name="password" value="123$567">

                       <div class="form-group"><label for="exampleFormControlInput1">EMAIL :</label>
                           <input class="form-control" id="exampleFormControlInput1" name="email" type="email" placeholder="Enter Student Email">
                           <span style="color: red">@error('student_name'){{"$message"}}@enderror</span>
                       </div>
                       <div class="form-group"><label for="exampleFormControlInput1">HOME ADDRESS :</label>
                           <input class="form-control" id="exampleFormControlInput1" name="address" type="text" placeholder="Enter Student Address">
                           <span style="color: red">@error('address'){{$message}}@enderror</span>
                       </div>
                       <div class="form-group"><label for="exampleFormControlInput1">ID NUMBER :</label>
                           <input class="form-control" id="exampleFormControlInput1" name="nic" type="text" placeholder="Enter Student NIC">
                           <span style="color: red">@error('nic'){{$message}}@enderror</span>
                       </div>
                       <div class="form-group"><label for="exampleFormControlInput1">CONTACT NUMBER :</label>
                           <input class="form-control" id="exampleFormControlInput1" maxlength="10" size="10" name="cnumber" type="number" placeholder="Enter Student Contact Number">
                           <span style="color: red">@error('cnumber'){{"The contact number field is required."}}@enderror</span>
                       </div>
                       <div class="form-group"><label for="exampleFormControlInput1">HOME NUMBER :</label>
                           <input class="form-control" id="exampleFormControlInput1"  name="hcnumber" type="number" maxlength="10" size="10" placeholder="Enter Student Home Number">
                           <span style="color: red">@error('hcnumber'){{"The home number field is required."}}@enderror</span>
                       </div>
                       <div class="panel panel-default">
                           <div class="panel-body">
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
                                   <span style="color: red">@error('stream'){{"The stream field is required."}}@enderror</span>
                               </div>
                               <div class="form-group">
                                   <label for="title">SELECT YEAR :</label>
                                   <select name="year" id="year" class="form-control">
                                       <option value="2025">2025</option>
                                       <option value="2026">2026</option>
                                       <option value="2027">2027</option>
                                       <option value="2028">2028</option>
                                   </select>
                                   <span style="color: red">@error('year'){{"The year field is required."}}@enderror</span>
                               </div>

                               <div class="form-group" >
                                   <label for="title">SELECT CLASS:</label>
                                   <div class="form-check" id="classx">

                                   </div>
                               </div>

                           </div>
                       </div>
                       <div class="form-group">
                           <input type="submit" class="form-control btn btn-info"   value="SUBMIT">
                       </div>
                   </form>
               </div>
           </div>
       </div>
   </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#stream, #year").change(function() {
                let stream = $("#stream").val();
                let year = $("#year").val();

                $.ajax({
                    url: "{{ route('Admin.getclass') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        stream: stream,
                        year: year
                    },
                    success: function(response) {
                        $("#classx").html(response);

                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;
                        if (errors) {
                            alert("Validation error! Please check your inputs.");
                        }
                    }
                });
            });
        });

    </script>
@endsection
